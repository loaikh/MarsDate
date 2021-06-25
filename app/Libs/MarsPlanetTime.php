<?php
/**
 * This Class for calculate Time between the Mars Planet and Earth ,
 * for more details ,Please check below links
 * https://www.eecis.udel.edu/~mills/missions.html
 * https://www.giss.nasa.gov/tools/mars24/help/algorithm.html
 * https://en.wikipedia.org/wiki/Timekeeping_on_Mars#Coordinated_Mars_Time_.28MTC.29
 */
namespace App\Libs;


use DateTimeImmutable;

class MarsPlanetTime implements PlanetTime
{

    private const NUMBER_OF_SECOND_PER_DAY= 86400;
    private  const  NUMBER_OF_SECOND_PER_HOUR=3600;
    private  const  NUMBER_OF_HOUR_PER_DAY=24;
    private  const  TIME_FORMAT='H:i:s';
    private  const  LEAP_SECOND_SINCE_2017 = 37 + 32.184;
    private  const J2000_EPOCH= 2451545.0;
    private  const JD_EPOCH= 2440587.5;
    private  const MIDNIGHT_ON_6TH_JANUARY_2000=4.5;
    private const DIVIDE_RATIO=1.0274912517;
    private  const MIDDAY_DECEMBER_29th_1873 =  44796.0;
    private  const FRACTION_DIGIT=5;



    public function timeConverter(DateTimeImmutable $dateTimeImmutable): array
    {
     //Time milliseconds since 1 Jan 1970
        $dTimeStamp = $dateTimeImmutable->getTimestamp();
        //JulianDate
        $dJDut = $this->calculateJDUT($dTimeStamp);
        //JulianDate
        $dJDtt = $this->calculateJDTT($dJDut);
        //Determine time offset from J2000
        $dDdeltaT2000 = $this->calculateDateSinceJ2000($dJDtt);
        //Mars Sol Date
        $dMSD = $this->calculateMSD($dDdeltaT2000);
        //Martian Coordinated Time
        $dMTC =  $this->calculateMartianCoordinated($dMSD);
        return array('MSD'=>$dMSD,'MTC'=>$dMTC);

    }

    /**
     * This Function is get  the number of days (rather than milliseconds) since a much older epoch than Unix time.
     * Rather than an elaborate conversion from the Gregorian date to the Julian date
     * , we just divide millis by 86,400,000 to get the number of days since the Unix epoch and add that number to 2,440,587.5,
     * the Julian Date at the Unix epoch.
     * @param string $timeStamp
     * @return float
     */
    private function calculateJDUT(string $timeStamp): float
    {
        return  self::JD_EPOCH+ ($timeStamp / self::NUMBER_OF_SECOND_PER_DAY);
    }

    /**
     * We actually need the Terrestrial Time (TT) Julian Date rather than the UTC-based one.
     * This means we basically just add the leap seconds which, since 1 January 2017 are 37 + 32.184.
     * @param float $JDut
     * @return float|int
     */
    private function calculateJDTT(float $dJDut): float
    {
        return  $dJDut + self::LEAP_SECOND_SINCE_2017 / self::NUMBER_OF_SECOND_PER_DAY;
    }

    /**
     * This is the number we're going to use as the input to many of our Mars calculations.
     * It's the number of (fractional) days since 12:00 on 1 January 2000 in Terrestrial Time.
     *  Determine time offset from J2000 epoch (TT)
     * @param float $dJDtt
     * @return float
     */
    private function calculateDateSinceJ2000(float  $dJDtt): float
    {
        return $dJDtt - self::J2000_EPOCH;
    }

    /**
     * The equivalent of the Julian Date for Mars is the Mars Sol Date.
     * At midnight on the 6th January 2000 (ΔtJ2000 = 4.5) it was midnight at the Martian prime meridian, so our starting point for Mars Sol Date is ΔtJ2000 − 4.5.
     * The length of a Martian day and Earth (Julian) day differ by a ratio of 1.027491252 so we divide by that.
     * By convention, to keep the MSD positive going back to midday December 29th 1873, we add 44,796.
     * There is a slight adjustment as the midnights weren't perfectly aligned. Allison, M., and M. McEwen 2000 has −0.00072 but the Mars24 site gives a more up-to-date −0.00096.
     * @param float $dDeltaT2000
     * @return float
     */
    private function calculateMSD(float $dDeltaT2000): float
    {
        $dMSD = ((($dDeltaT2000 - self::MIDNIGHT_ON_6TH_JANUARY_2000) / self::DIVIDE_RATIO) + self::MIDDAY_DECEMBER_29th_1873 - 0.00096);

        return round($dMSD,self::FRACTION_DIGIT );
    }

    /**
     * Coordinated Mars Time (or MTC) is like UTC but for Mars.
     * Because it is just a mean time, it can be calculated directly from the Mars Sol Date
     * @param float $dMSD
     * @return String
     */
    private function calculateMartianCoordinated(float $dMSD): String
    {
        $dMTC = fmod(self::NUMBER_OF_HOUR_PER_DAY * $dMSD, self::NUMBER_OF_HOUR_PER_DAY);

        return gmdate(self::TIME_FORMAT, (int)floor($dMTC * self::NUMBER_OF_SECOND_PER_HOUR));
    }


}
