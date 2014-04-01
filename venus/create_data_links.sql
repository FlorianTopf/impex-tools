CREATE TABLE vex.data_links
(
  "time_min" timestamp without time zone NOT NULL,
  "time_max" timestamp without time zone NOT NULL,
  filename text
  
)
WITH (OIDS=FALSE);
ALTER TABLE vex.data_links OWNER TO gavoadmin;
GRANT ALL ON TABLE vex.data_links TO gavoadmin;
GRANT SELECT ON TABLE vex.data_links TO untrusted;
GRANT SELECT ON TABLE vex.data_links TO gavo;