<?xml version="1.0" encoding="utf-8"?>

<resource schema="IMPEX_SIM_TREES">
	<meta name="title">IMPEx simulation archives</meta>
	<meta name="creationDate">2014-01-30T12:00:00Z</meta>
	<meta name="description" format="plain">
	      Simulated magnetospheric data from FMI HYB/GUMICS model, LATMOS HYB model and SINP PMM model
	</meta>
	<meta name="copyright">Free to use.</meta>
	<meta name="creator.name">Topf, F.</meta>
	<meta name="subject">Magnetosphere modeling</meta>

<table id="epn_core" onDisk="True" adql="True">
	<meta name="info" infoName="SERVICE_PROTOCOL" infoValue="0.37">EPN-TAP</meta>
	<meta name="description">Simulated magnetospheric data available through IMPEx</meta>
	<meta name="referenceURL">http://impex-fp7.oeaw.ac.at</meta>
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
	<column name="preview_url" type="text"
		ucd="meta.id;meta.file"
		description="URL of a preview image"/>
	<column name="species" type="text"
		ucd="phys.composition.species"
		description="Identifies a chemical species"/>
	<!-- TODO descriptions and UCDs missing -->
	<column name="particle_spectral_type" type="text"/>
	<!-- TODO descriptions missing -->
	<column name="particle_spectral_range_min" type="double precision"
		ucd="phys.energy;phys.part;stat.min"/>
	<column name="particle_spectral_range_max" type="double precision"
		ucd="phys.energy:phys.part;stat.max"/>
    	<column name="processing_level" type="integer" required="True"
      		ucd="meta.code;obs.calib" 
      		description="Type of calibration"/>
    	<column name="publisher" type="text"
      		ucd="meta.name"
      		description="Publisher of the resource"/>
	<column name="reference"/>
    	<column name="service_title" type="text"
      		ucd="meta.note"
      		description="Title of the resource"/>
    	<column name="target_region" type="text"
      		ucd="meta.id;class"
      		description="Region of interest from a enumerated list"/>
	<column name="reference_id" type="text"
		ucd="meta.ref.uri"
		description="Reference to the related simulation model"/>
	<!-- TODO descriptions and UCDs missing -->
	<column name="input_particle_nvT" type="text"/>
	<column name="input_process" type="text"/>
	<column name="input_parameter" type="text"/>
</table>

<data id="import_content">
	<make table="epn_core"/>
</data>

<data id="collection" auto="false">
	<register services="__system__/tap#run"/>
	<make table="epn_core"/>
</data>
</resource>
