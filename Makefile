SHELL := /bin/bash

cities:
	curl -L -o import/cities.csv https://www.data.gouv.fr/fr/datasets/r/c59f06eb-2293-4b94-83be-6e9bf70f83af
	symfony console app:import-cities
.PHONIE: cities