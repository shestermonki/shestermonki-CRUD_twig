#!/bin/bash

docker exec -it $(docker ps | grep sudoku_db | cut -f 1 -d " ") mysql -u root -ppassword sudokudb
