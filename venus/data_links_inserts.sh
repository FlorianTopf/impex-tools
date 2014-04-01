#!/bin/bash

DIR_FROM="/home/amda-ftp/MAG/VSO"

DIR_TO="/home/gavo/venus"

cd ${DIR_FROM}/
find *.xml > logfile.txt

echo "INSERT INTO vex.data_links (time_min, time_max, filename) VALUES " >> ${DIR_TO}/data_links_inserts.sql

cat < ${DIR_FROM}/logfile.txt | while read -a FILENAME;
do
  echo "PROCESSING FILES..";
  echo "${FILENAME[0]}";

  #extracting filenames
  IFS='_' read -a DATETIME <<< "${FILENAME[0]}";
  echo "${DATETIME[1]}";

  #extracting time
  IFS='T' read -a TIME <<< "${DATETIME[1]}";
  echo "${TIME[0]} 23:59:59";
  
  echo "('${TIME[0]} 00:00:00', '${TIME[0]} 23:59:59', '${FILENAME[0]}')," >> ${DIR_TO}/data_links_inserts.sql
  
done
