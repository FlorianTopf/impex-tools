<?xml version="1.0" encoding="utf-8"?>

<resource schema="VEX_MAG_VSO">
	<meta name="title">Venus Express Magnetometer Data</meta>
	<meta name="creationDate">2014-01-27T12:00:00Z</meta>
	<meta name="description" format="plain">
	      Venus Express Observations of the Magnetic Field in VSO Coordinates including Spacecraft Positions
	</meta>
	<meta name="copyright">Free to use.</meta>
	<meta name="creator.name">Topf, F.; Zhang, T.</meta>
	<meta name="subject">Venus Magnetosphere</meta>

<table id="epn_core" onDisk="True" adql="True">
	<meta name="info" infoName="SERVICE_PROTOCOL" infoValue="0.35">EPN-TAP</meta>
	<meta name="description">Venus Magnetic Field in VSO Coordinates</meta>
	<meta name="referenceURL">http://www.agu.org/pubs/crossref/2008/2008JE003215.shtml</meta>
	<column name="index" type="bigint"
		ucd="meta.id"
		description="unique line number in the table"/>
    	<column name="resource_type" type="text" 
      		ucd="meta.id;class" 
      		description="resource type can be dataset or granule"/>
	<column name="dataset_id" type="text"
		ucd="meta.id;meta.dataset"
		description="unique id of the dataset stored in the table"/>
    	<column name="dataproduct_type" type="text" 
      		ucd="meta.id;class" 
      		description="Organization of the data product, from enumerated list"/>
    	<column name="target_name" type="text" 
      		ucd="meta.id;src" 
      		description="Name of target (from a list depending on target type)"/>
    	<column name="target_class" type="text" 
      		ucd="src.class" 
      		description="Type of target from enumerated list"/>
    	<column name="time_min" type="double precision" 
      		ucd="time.start" unit="d"
      		description="Acquisition start time (in JD)"/>
    	<column name="time_max" type="double precision"
      		ucd="time.end" unit="d"
      		description="Acquisition stop time (in JD)"/>
    	<column name="time_sampling_step_min" 
      		ucd="time.interval;stat.min" unit="s"
      		description="Min time sampling step"/>
    	<column name="time_sampling_step_max" 
      		ucd="time.interval;stat.max" unit="s"
      		description="Max time sampling step"/>
    	<column name="time_exp_min" 
      		ucd="time.duration;obs.exposure;stat.min"  unit="s"
      		description="Min integration time"/>
    	<column name="time_exp_max" 
      		ucd="time.duration;obs.exposure;stat.max"  unit="s"
      		description="Max integration time"/>
    	<column name="spectral_range_min" 
      		ucd="em.freq;stat.min" unit="Hz"
      		description="Min spectral range (frequency)"/>
    	<column name="spectral_range_max" 
      		ucd="em.freq;stat.max" unit="Hz"
      		description="Max spectral range (frequency)"/>
    	<column name="spectral_sampling_step_min" 
        	ucd="em.freq.step;stat.min" unit="Hz"
      		description="Min spectral sampling step"/>
    	<column name="spectral_sampling_step_max" 
        	ucd="em.freq.step;stat.max" unit="Hz"
      		description="Max spectral sampling step"/>
    	<column name="spectral_resolution_min" 
      		ucd="spec.resolution;stat.min" unit="Hz"
      		description="Min spectral resolution"/>
    	<column name="spectral_resolution_max" 
      		ucd="spec.resolution;stat.max" unit="Hz"
      		description="Max spectral resolution"/>
    	<column name="c1min" 
      		ucd="pos;stat.min" unit="deg"
      		description="Min of first coordinate"/>
    	<column name="c1max" 
      		ucd="pos;stat.max" unit="deg"
      		description="Max of first coordinate"/>
    	<column name="c2min" 
      		ucd="pos;stat.min" unit="deg"
      		description="Min of first coordinate"/>
    	<column name="c2max" 
      		ucd="pos;stat.max" unit="deg"
      		description="Max of first coordinate"/>
    	<column name="c3min" 
      		ucd="pos;stat.min" unit=""
      		description="Min of third coordinate"/>
    	<column name="c3max" 
      		ucd="pos;stat.max" unit=""
      		description="Max of third coordinate"/>
    	<column name="c1_resol_min" 
      		ucd="pos.angResolution;stat.min" unit="deg"
      		description="Min resolution in first coordinate"/>
    	<column name="c1_resol_max" 
      		ucd="pos.angResolution;stat.max" unit="deg"
      		description="Max resolution in first coordinate"/>
    	<column name="c2_resol_min" 
      		ucd="pos.angResolution;stat.min" unit="deg"
      		description="Min resolution in second coordinate"/>
    	<column name="c2_resol_max" 
      		ucd="pos.angResolution;stat.max" unit="deg"
      		description="Max resolution in second coordinate"/>
    	<column name="c3_resol_min" 
      		ucd="pos.Resolution;stat.min" unit=""
      		description="Min resolution in third coordinate"/>
    	<column name="c3_resol_max" 
      		ucd="pos.Resolution;stat.min" unit=""
      		description="Max resolution in third coordinate"/>
    	<column name="spatial_frame_type" type="text" 
      		ucd="meta.id;class" 
      		description="Flavor of coordinate system, defines the nature of coordinates"/>
    	<column name="incidence_min" unit="deg" 
      		ucd="pos.posang;stat.min" 
      		description="Min incidence angle (solar zenithal angle)"/>
    	<column name="incidence_max" unit="deg" 
      		ucd="pos.posang;stat.max" 
      		description="Max incidence angle (solar zenithal angle) "/>
    	<column name="emergence_min" unit="deg" 
      		ucd="pos.posang;stat.min" 
      		description="Min emergence angle"/>
    	<column name="emergence_max" unit="deg" 
      		ucd="pos.posang;stat.max" 
      		description="Max emergence angle"/>
    	<column name="phase_min" unit="deg" 
      		ucd="pos.posang;stat.min" 
      		description="Min phase angle"/>
    	<column name="phase_max" unit="deg" 
      		ucd="pos.posang;stat.max" 
      		description="Max phase angle"/>
    	<column name="instrument_host_name" type="text" 
      		ucd="meta.class" 
      		description="Standard name of the observatory or spacecraft"/>
    	<column name="instrument_name" type="text" 
      		ucd="meta.id;instr" 
      		description="Standard name of instrument"/>
    	<column name="measurement_type" type="text" 
      		ucd="meta.ucd" 
      		description="UCD(s) defining the data"/>
	<column name="access_url" type="text" 
      		ucd="meta.ref.url" 
      		description="URL of the data files"/>
    	<column name="access_format" type="text"
      		ucd="meta.code.mime" 
      		description="File format type"/>
    	<column name="access_estsize" type="integer" unit="kB" required="True"
      		ucd="phys.size;meta.file"
      		description="Estimate file size in kB"/>
    	<column name="target_region" type="text"
      		ucd="meta.id;class"
      		description="Region of interest from a enumerated list"/>
	<column name="file_name" type="text"
		ucd="meta.id;meta.file"
		description="Name of the file stored at the access_url"/>
    	<column name="reference" type="text"
      		ucd="meta.bib"
      		description="Publication of reference"/>
    	<column name="processing_level" type="integer" required="True"
      		ucd="meta.code;obs.calib" 
      		description="Type of calibration"/>
    	<column name="service_title" type="text"
      		ucd="meta.note"
      		description="Title of the resource"/>
    	<column name="publisher" type="text"
      		ucd="meta.name"
      		description="Publisher of the ressource"/>
    	<column name="time_scale" type="text" 
      		ucd="time.scale" 
      		description="Time scale taken from STC"/> 
<!--	<column name="TIME" type="timestamp" required="True" 
		ucd="obs.exposure"
		description="IS0-8601 timestamp of the observation in 4s interval"/> -->
	<column name="B_SC_X" 
		ucd="phys.magField;pos.cartesian.x"
		description="Magnetic Field Vector - X component in SC coordinates"/>
	<column name="B_SC_Y" 
		ucd="phys.magField;pos.cartesian.y"
		description="Magnetic Field Vector - Y component in SC coordinates"/>
	<column name="B_SC_Z" 
		ucd="phys.magField;pos.cartesian.z"
		description="Magnetic Field Vector - Z component in SC coordinates"/>
	<column name="B_VSO_X" 
		ucd="phys.magField;pos.cartesian.z"
		description="Magnetic Field Vector - X component in VSO coordinates"/>
	<column name="B_VSO_Y" 
		ucd="phys.magField;pos.cartesian.z"
		description="Magnetic Field Vector - Y component in VSO coordinates"/>
	<column name="B_VSO_Z" 
		ucd="phys.magField;pos.cartesian.z"
		description="Magnetic Field Vector - Z component in VSO coordinates"/>
	<column name="POS_VSO_X" 
		ucd="pos.cartesian.x"
		description="Spacecraft position - X component in VSO coordinates"/>
	<column name="POS_VSO_Y" 
		ucd="pos.cartesian.y"
		description="Spacecraft position - Y component in VSO coordinates"/>
	<column name="POS_VSO_Z" 
		ucd="pos.cartesian.z" 
		description="Spacecraft position - Z component in VSO coordinates"/>
</table>

<data id="import_content">
<!--	<sources pattern="/home/amda-ftp/MAG/VSO/*.dat"/>
	<reGrammar>
		<names>TIME, 
		B_SC_X, B_SC_Y, B_SC_Z, 
		B_VSO_X, B_VSO_Y, B_VSO_Z, 
		POS_VSO_X, POS_VSO_Y, POS_VSO_Z</names>
	</reGrammar>

	<make table="epn_core">
		<rowmaker id="build_epn_core" idmaps="*">
			<var name="TIME">@TIME</var>
			<var name="POS_VSO_X">float(@POS_VSO_X)</var>
			<var name="POS_VSO_Y">float(@POS_VSO_Y)</var>
			<var name="POS_VSO_Z">float(@POS_VSO_Z)</var>
			<map dest="B_SC_X">parseWithNull(@B_SC_X, float, "99999.999")</map>
			<map dest="B_SC_Y">parseWithNull(@B_SC_Y, float, "99999.999")</map>
			<map dest="B_SC_Z">parseWithNull(@B_SC_Z, float, "99999.999")</map>
			<map dest="B_VSO_X">parseWithNull(@B_VSO_X, float, "99999.999")</map>
			<map dest="B_VSO_Y">parseWithNull(@B_VSO_Y, float, "99999.999")</map>
			<map dest="B_VSO_Z">parseWithNull(@B_VSO_Z, float, "99999.999")</map>
		</rowmaker>
	</make> -->
	<make table="epn_core"/>
</data>

<data id="collection" auto="false">
	<register services="__system__/tap#run"/>
	<make table="epn_core"/>
</data>
</resource>
