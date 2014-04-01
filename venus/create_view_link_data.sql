CREATE OR REPLACE VIEW vex_mag_vso.epn_core AS SELECT
/* compulsory parameter */
row_number() OVER () AS index,
text 'granule' AS resource_type, 
text 'spase://iwf/numericalData/Vex_Mag_VSO' AS dataset_id, 
text 'ts' AS dataproduct_type, 
text 'Venus' AS target_name,
text 'planet' AS target_class, 
cast(to_char(time_min::timestamp,'J') AS double precision) + EXTRACT(EPOCH FROM time_min::time)/86400-0.5 AS time_min,
cast(to_char(time_max::timestamp,'J') AS double precision) + EXTRACT(EPOCH FROM time_max::time)/86400-0.5+0.00004 AS time_max,
integer '4' AS time_sampling_step_min,
integer '4' AS time_sampling_step_max,
NULL AS time_exp_min,
NULL AS time_exp_max,
NULL AS spectral_range_min,
NULL AS spectral_range_max,
NULL AS spectral_sampling_step_min,
NULL AS spectral_sampling_step_max,
NULL AS spectral_resolution_min,
NULL AS spectral_resolution_max,
NULL AS c1min,
NULL AS c1max,
NULL AS c2min,
NULL AS c2max,
NULL AS c3min,
NULL AS c3max,
NULL AS c1_resol_min,
NULL AS c1_resol_max,
NULL AS c2_resol_min,
NULL AS c2_resol_max,
NULL AS c3_resol_min,
NULL AS c3_resol_max,
NULL AS spatial_frame_type,
NULL AS incidence_min,
NULL AS incidence_max,
NULL AS emergence_min,
NULL AS emergence_max,
NULL AS phase_min,
NULL AS phase_max,
text 'Venus Express' AS instrument_host_name,
text 'Magnetometer' AS instrument_name, 
text 'phys.magField' AS measurement_type,
/* optional parameters */
text 'ftp://amda-idis.oeaw.ac.at/MAG/VSO/' || filename AS access_url,
text 'votable' AS access_format,
integer '2150' AS access_estsize,
text (filename) AS file_name,
text '10.1029/2008JE003215' AS reference,
/* parameter attributes */
integer '5' AS processing_level,
/* service properties */
text 'EPN-TAP' AS service_protocol,
text 'Venus Express Magnetometer Data' AS service_title,
text 'IDIS Plasma Node on behalf of PI Tielong Zhang' AS publisher,
/* not sure about this */
text 'vso' AS spatial_coordinate_description,
text 'magnetosphere' AS target_region,
text 'utc' AS time_scale
FROM vex.data_links
UNION ALL
SELECT
/* compulsory parameter */
row_number() OVER () AS index,
text 'granule' AS resource_type, 
text 'spase://iwf/numericalData/Vex_Mag_VSO' AS dataset_id, 
text 'ts' AS dataproduct_type, 
text 'venus' AS target_name,
text 'planet' AS target_class, 
cast(to_char(time_min::timestamp,'J') AS double precision) + EXTRACT(EPOCH FROM time_min::time)/86400-0.5 AS time_min,
cast(to_char(time_max::timestamp,'J') AS double precision) + EXTRACT(EPOCH FROM time_max::time)/86400-0.5+0.00004 AS time_max,
integer '4' AS time_sampling_step_min,
integer '4' AS time_sampling_step_max,
NULL AS time_exp_min,
NULL AS time_exp_max,
NULL AS spectral_range_min,
NULL AS spectral_range_max,
NULL AS spectral_sampling_step_min,
NULL AS spectral_sampling_step_max,
NULL AS spectral_resolution_min,
NULL AS spectral_resolution_max,
NULL AS c1min,
NULL AS c1max,
NULL AS c2min,
NULL AS c2max,
NULL AS c3min,
NULL AS c3max,
NULL AS c1_resol_min,
NULL AS c1_resol_max,
NULL AS c2_resol_min,
NULL AS c2_resol_max,
NULL AS c3_resol_min,
NULL AS c3_resol_max,
NULL AS spatial_frame_type,
NULL AS incidence_min,
NULL AS incidence_max,
NULL AS emergence_min,
NULL AS emergence_max,
NULL AS phase_min,
NULL AS phase_max,
text 'Venus Express' AS instrument_host_name,
text 'Magnetometer' AS instrument_name, 
text 'phys.magField' AS measurement_type,
/* optional parameters */
text 'ftp://amda-idis.oeaw.ac.at/MAG/VSO/' || filename AS access_url,
text 'votable' AS access_format,
integer '2150' AS access_estsize,
text (filename) AS file_name,
text '10.1029/2008JE003215' AS reference,
/* parameter attributes */
integer '5' AS processing_level,
/* service properties */
text 'EPN-TAP' AS service_protocol,
text 'Venus Express Magnetometer Data' AS service_title,
text 'IDIS Plasma Node on behalf of PI Tielong Zhang' AS publisher,
/* not sure about this */
text 'vso' AS spatial_coordinate_description,
text 'magnetosphere' AS target_region,
text 'utc' AS time_scale
FROM vex.data_links;

GRANT ALL PRIVILEGES ON SCHEMA vex_mag_vso to gavo WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON SCHEMA vex_mag_vso to gavoadmin WITH GRANT OPTION;
GRANT USAGE ON SCHEMA vex_mag_vso TO untrusted;

GRANT ALL PRIVILEGES ON vex_mag_vso.epn_core to gavoadmin WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON vex_mag_vso.epn_core to gavo WITH GRANT OPTION;
GRANT SELECT ON TABLE vex_mag_vso.epn_core TO untrusted;

