{
	"info": {
		"_postman_id": "bb38b7aa-9720-4105-bab9-a709aa1ce1f7",
		"name": "MarsTime",
		"schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json"
	},
	"item": [
		{
			"name": "MSD",
			"request": {
				"method": "GET",
				"header": [],
				"url": {
					"raw": "localhost:8000/api/v1/planets/time/Mars/?earthDate=5 June 2021 18:02:00 UTC",
					"host": [
						"localhost"
					],
					"port": "8000",
					"path": [
						"api",
						"v1",
						"planets",
						"time",
						"Mars",
						""
					],
					"query": [
						{
							"key": "earthDate",
							"value": "5 June 2021 18:02:00 UTC"
						}
					]
				},
				"description": "Mars Time"
			},
			"response": []
		},
		{
			"name": "MSD With Exception",
			"request": {
				"method": "GET",
				"header": [],
				"url": {
					"raw": "localhost:8000/api/v1/planets/time/Mars/?earthDate=5 June 2021 18:02:00",
					"host": [
						"localhost"
					],
					"port": "8000",
					"path": [
						"api",
						"v1",
						"planets",
						"time",
						"Mars",
						""
					],
					"query": [
						{
							"key": "earthDate",
							"value": "5 June 2021 18:02:00"
						}
					]
				},
				"description": "Mars Time"
			},
			"response": []
		},
		{
			"name": "MSD With Exception Planet",
			"request": {
				"method": "GET",
				"header": [],
				"url": {
					"raw": "localhost:8000/api/v1/planets/time/Moon/?earthDate=5 Jun 2021 18:02:00 UTC",
					"host": [
						"localhost"
					],
					"port": "8000",
					"path": [
						"api",
						"v1",
						"planets",
						"time",
						"Moon",
						""
					],
					"query": [
						{
							"key": "earthDate",
							"value": "5 Jun 2021 18:02:00 UTC"
						}
					]
				},
				"description": "Mars Time"
			},
			"response": []
		}
	]
}