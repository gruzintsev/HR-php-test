#!/usr/bin/env bash
mysql -uhomestead -psecret flowerstest < dump.sql
mysql -uhomestead -psecret -e "SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));"
