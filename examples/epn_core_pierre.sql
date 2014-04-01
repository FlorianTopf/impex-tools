CREATE OR REPLACE VIEW epn_core AS SELECT
	TEXT 'granule'								AS resource_type,
	regexp_replace(regexp_replace(obstype,
		'IMAGING','image'),'SPECTROSCOPIC','spectrum') 
												AS dataproduct_type,
	lower(targname)								AS target_name,
	TEXT 'planet'								AS target_class,
	CAST(to_char(datetime::date,'J') AS double precision) 
												AS time_min,
	CAST(to_char(date::date,'J') AS double precision) + texptime/3600 
												AS time_max,
	NULL										AS time_sampling_step_min,
	NULL										AS time_sampling_step_max,
	texptime/3600								AS time_exp_min,
	texptime/3600								AS time_exp_max,
	3E18/maxwave								AS spectral_range_min,
	3E18/minwave								AS spectral_range_max,
	NULL										AS spectral_sampling_step_min,
	NULL										AS spectral_sampling_step_max,
	NULL										AS spectral_resolution_min,
	NULL										AS spectral_resolution_max,
	'0'											AS c1min,
	'360'										AS c1max,
	'-90'										AS c2min,
	'180'										AS c2max,
	NULL										AS c3min,
	NULL										AS c3max,
	NULL										AS c1_resol_min,
	NULL										AS c1_resol_max,
	NULL										AS c2_resol_min,
	NULL										AS c2_resol_max,
	NULL										AS c3_resol_min,
	NULL										AS c3_resol_max,
	TEXT 'body'									AS spatial_frame_type,
	telescop									AS instrument_host_name,
	detector									AS instrument_name,
	TEXT 'obs.image'							AS measurement_type,
	TEXT 'http://voparis-srv.obspm.fr/vo/planeto/apis/dataset/' || calibrated_filename
												AS access_url,
	TEXT 'fits'									AS access_format,
	INTEGER '22000'								AS access_estsize,
	integer '3'							AS processing_level,
	TEXT 'vo paris data centre on behalf of LESIA' 
												AS publisher,
	TEXT 'no information'						AS reference,
	TEXT 'Aurora Planetary Imaging and Spectroscopy' 
												AS title,
	TEXT 'planetary aurorae'					AS target_region,
	ra_targ										AS ra,
	dec_targ									AS dec,
	-- calibrated files 
	CASE calibrated_preview
		WHEN ''  THEN CAST(NULL AS TEXT) 
		WHEN NULL  THEN CAST(NULL AS TEXT) 
		ELSE TEXT 'http://voparis-srv.obspm.fr/vo/planeto/apis/dataset/' || calibrated_preview END
												AS access_url_calibrated_preview,
	CASE calibrated_preview
		WHEN ''  THEN CAST(NULL AS TEXT) 
		WHEN NULL  THEN CAST(NULL AS TEXT) 
		ELSE TEXT 'http://voparis-srv.obspm.fr/vo/planeto/apis/dataset/' || 
		regexp_replace(calibrated_preview, '.jpg', '_small.jpg')	END
												AS access_url_calibrated_thumbnail,						
	-- processed files 
	CASE processed_filename
		WHEN ''  THEN CAST(NULL AS TEXT) 
		WHEN NULL  THEN CAST(NULL AS TEXT) 
		ELSE TEXT 'http://voparis-srv.obspm.fr/vo/planeto/apis/dataset/' || processed_filename  END
												AS access_url_processed_filename,
	CASE processed_preview
		WHEN ''  THEN CAST(NULL AS TEXT) 
		WHEN NULL  THEN CAST(NULL AS TEXT) 
		ELSE TEXT 'http://voparis-srv.obspm.fr/vo/planeto/apis/dataset/' || processed_preview  END
												AS access_url_processed_preview,
	CASE processed_preview
		WHEN ''  THEN CAST(NULL AS TEXT) 
		WHEN NULL  THEN CAST(NULL AS TEXT) 
		ELSE TEXT 'http://voparis-srv.obspm.fr/vo/planeto/apis/dataset/' || 
		regexp_replace(processed_preview, '.jpg', '_small.jpg')	 END
												AS access_url_processed_thumbnail,
	-- cylindric files 
	CASE cylindric_filename
		WHEN ''  THEN CAST(NULL AS TEXT) 
		WHEN NULL  THEN CAST(NULL AS TEXT) 
		ELSE TEXT 'http://voparis-srv.obspm.fr/vo/planeto/apis/dataset/' || cylindric_filename  END
												AS access_url_cylindric_filename,
	CASE cylindric_preview
		WHEN ''  THEN CAST(NULL AS TEXT) 
		WHEN NULL  THEN CAST(NULL AS TEXT) 
		ELSE TEXT 'http://voparis-srv.obspm.fr/vo/planeto/apis/dataset/' || cylindric_preview  END
												AS access_url_cylindric_preview,
	CASE cylindric_preview
		WHEN ''  THEN CAST(NULL AS TEXT) 
		WHEN NULL  THEN CAST(NULL AS TEXT) 
		ELSE TEXT 'http://voparis-srv.obspm.fr/vo/planeto/apis/dataset/' || 
		regexp_replace(cylindric_preview, '.jpg', '_small.jpg')	 END
												AS access_url_cylindric_thumbnail,
	-- polar files 
	CASE polar_filename
		WHEN ''  THEN CAST(NULL AS TEXT) 
		WHEN NULL  THEN CAST(NULL AS TEXT) 
		ELSE TEXT 'http://voparis-srv.obspm.fr/vo/planeto/apis/dataset/' || polar_filename END
												AS access_url_polar_filename,
	CASE polar_preview
		WHEN ''  THEN CAST(NULL AS TEXT) 
		WHEN NULL  THEN CAST(NULL AS TEXT) 
		ELSE TEXT 'http://voparis-srv.obspm.fr/vo/planeto/apis/dataset/' || polar_preview END
												AS access_url_polar_preview,
	CASE polar_preview 
		WHEN ''  THEN CAST(NULL AS TEXT) 
		WHEN NULL  THEN CAST(NULL AS TEXT) 
		ELSE TEXT 'http://voparis-srv.obspm.fr/vo/planeto/apis/dataset/' || 
		regexp_replace(polar_preview, '.jpg', '_small.jpg')	END
												AS access_url_polar_thumbnail
FROM apis_data UNION ALL SELECT
	resource_type AS resource_type,
	dataproduct_type AS dataproduct_type,
	target_name AS target_name,
	target_class AS target_class,
	t_min AS t_min,
	t_max AS t_max,
	t_scale AS t_scale,
	t_sampling_step_min AS t_sampling_step_min,
	t_sampling_step_max AS t_sampling_step_max,
	t_exp_min AS t_exp_min,
	t_exp_max AS t_exp_max,
	spectral_range_min AS spectral_range_min,
	spectral_range_max AS spectral_range_max,
	spectral_sampling_step_min AS spectral_sampling_step_min,
	spectral_sampling_step_max AS spectral_sampling_step_max,
	spectral_resolution_min AS spectral_resolution_min,
	spectral_resolution_max AS spectral_resolution_max,
	c1min AS c1min,
	c1max AS c1max,
	c2min AS c2min,
	c2max AS c2max,
	c3min AS c3min,
	c3max AS c3max,
	c1_resol_min AS c1_resol_min,
	c1_resol_max AS c1_resol_max,
	c2_resol_min AS c2_resol_min,
	c2_resol_max AS c2_resol_max,
	c3_resol_min AS c3_resol_min,
	c3_resol_max AS c3_resol_max,
	spatial_frame_type AS spatial_frame_type,
	instrument_host_name AS instrument_host_name,
	instrument_name AS instrument_name,
	measurement_type AS measurement_type,
	access_url AS access_url,
	access_format AS access_format,
	access_estsize AS access_estsize,
	integet '3' AS processing_level,
	publisher AS publisher,
	reference AS reference,
	title AS title,
	target_region AS target_region,
	NULL AS ra,
	NULL AS dec,
	NULL AS access_url_calibrated_preview,
	NULL AS access_url_calibrated_thumbnail,
	NULL AS access_url_processed_filename,
	NULL AS access_url_processed_preview,
	NULL AS access_url_processed_thumbnail,
	NULL AS access_url_cylindric_filename,
	NULL AS access_url_cylindric_preview,
	NULL AS access_url_cylindric_thumbnail,
	NULL AS access_url_polar_filename,
	NULL AS access_url_polar_preview,
	NULL AS access_url_polar_thumbnail
	FROM apis_dataset;
