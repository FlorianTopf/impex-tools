SELECT cast(to_char(time::timestamp,'J') as double precision) + EXTRACT(EPOCH FROM time::time)/86400-0.5 AS time_min FROM vex.data LIMIT 10;
