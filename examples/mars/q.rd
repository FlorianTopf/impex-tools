<?xml version="1.0" encoding="iso-8859-1"?>

<resource schema="vo_mars">
  <meta name="title">Mars atmospheric profile auguste</meta>
  <meta name="creationDate">2012-02-27T08:42:00Z</meta>
  <meta name="description" format="plain">
    Ozone profile in mars atmosphere data from Alain Sarkissian
  </meta>
  <meta name="copyright">Free to use</meta>
  <meta name="creator.name">A. Sarkissian</meta>
  <meta name="subject">Mars atmosphere</meta>
  <meta name="subject">Ozone profile</meta>
  <meta name="subject">Extinction</meta>


<table id="epn_core" onDisk="True" adql="True">
    <meta name="info" infoName="SERVICE_PROTOCOL" infoValue="0.3">EPN-TAP</meta>
    <meta name="description"> ozone in mars atmosphere.  </meta>
    <meta name="referenceURL">http://cdsads.u-strasbg.fr/abs/1989Natur.341..600B
</meta>
    <column name="resource_type" type="text" 
      ucd="meta.id;class" 
      description="ressource type can be dataset or granule"/>
    <column name="dataproduct_type"  type="text" 
      ucd="meta.id;class" 
      description="Organization of the data product, from enumerated list"/>
    <column name="target_name"  type="text" 
      ucd="meta.id;src" 
      description="name of target (from a list depending on target type)"/>
    <column name="target_class"  type="text" 
      ucd="src.class" 
      description="type of target from enumerated list"/>
    <column name="time_min" 
      ucd="time.start;obs.exposure" unit="d"
      description="Acquisition start time (in JD)"/>
    <column name="time_max" 
      ucd="time.end;obs.exposure" unit="d"
      description="Acquisition stop time (in JD)"/>
    <column name="time_sampling_step_min" 
      ucd="time.interval;stat.min"  unit="s"
      description="Min time sampling step"/>
    <column name="time_sampling_step_max" 
      ucd="time.interval;stat.max"  unit="s"
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
      description="min spectral sampling step"/>
    <column name="spectral_sampling_step_max" 
        ucd="em.freq.step;stat.max" unit="Hz"
      description="max spectral sampling step"/>
    <column name="spectral_resolution_min" 
      ucd="spec.resolution;stat.min" unit="Hz"
      description="Min spectral resolution"/>
    <column name="spectral_resolution_max" 
      ucd="spec.resolution;stat.max" unit="Hz"
      description="Max spectral resolution"/>
    <column name="c1min" 
      ucd="pos;stat.min" unit="deg"
      description="Min longitude on mars"/>
    <column name="c1max" 
      ucd="pos;stat.max" unit="deg"
      description="Max longitude on mars"/>
    <column name="c2min" 
      ucd="pos;stat.min" unit="deg"
      description="Min latitude on mars"/>
    <column name="c2max" 
      ucd="pos;stat.max" unit="deg"
      description="Max latitude on mars"/>
    <column name="c3min" 
      ucd="pos;stat.min" unit=""
      description="Min of third coordinate (not used)"/>
    <column name="c3max" 
      ucd="pos;stat.max" unit=""
      description="Max of third coordinate (not used)"/>
    <column name="c1_resol_min" 
      ucd="pos.angResolution;stat.min" unit="deg"
      description="Min resolution on mars longitude"/>
    <column name="c1_resol_max" 
      ucd="pos.angResolution;stat.max" unit="deg"
      description="Max resolution on mars longitude"/>
    <column name="c2_resol_min" 
      ucd="pos.angResolution;stat.min" unit="deg"
      description="Min resolution on mars latitude"/>
    <column name="c2_resol_max" 
      ucd="pos.angResolution;stat.max" unit="deg"
      description="Max resolution on mars latitude"/>
    <column name="c3_resol_min" 
      ucd="pos.Resolution;stat.min" unit=""
      description="Min resolution in third coordinate"/>
    <column name="c3_resol_max" 
      ucd="pos.Resolution;stat.min" unit=""
      description="Min resolution in third coordinate"/>
    <column name="spatial_frame_type"  type="text" 
      ucd="meta.id;class" 
      description="Flavor of coordinate system, defines the nature of coordinates (enumerated list)"/>
    <column name="incidence_min"  unit="deg" 
      ucd="pos.posang;stat.min" 
      description="Min incidence angle (solar zenithal angle)"/>
    <column name="incidence_max"  unit="deg" 
      ucd="pos.posang;stat.max" 
      description="Max incidence angle (solar zenithal angle) "/>
    <column name="emergence_min"  unit="deg" 
      ucd="pos.posang;stat.min" 
      description="Min emergence angle"/>
    <column name="emergence_max"  unit="deg" 
      ucd="pos.posang;stat.max" 
      description="Max emergence angle"/>
    <column name="phase_min"  unit="deg" 
      ucd="pos.posang;stat.min" 
      description="Min phase angle"/>
    <column name="phase_max"  unit="deg" 
      ucd="pos.posang;stat.max" 
      description="Max phase angle"/>
    <column name="instrument_host_name"  type="text" 
      ucd="meta.code" 
      description="Standard name of the observatory or spacecraft"/>
    <column name="instrument_name"  type="text" 
      ucd="meta.id;instr" 
      description="Standard name of instrument"/>
    <column name="measurement_type"  type="text" 
      ucd="meta.ucd" 
      description="UCD(s) defining the data"/>
    <column name="access_url"  type="text" 
      ucd="meta.ref.url" 
      description="URL of the data files."/>
    <column name="access_format"  type="text"
      ucd="meta.id;class" 
      description="file format type."/>
    <column name="access_estsize"  type="integer" unit="kB" required="True"
      ucd="phys.size;meta.file"
      description="estimate file size in kB."/>
    <column name="processing_level"  type="integer" required="True"
      ucd="meta.class.qual" 
      description="type of calibration from CODMAC."/>
    <column name="publisher"  type="text"
      ucd="meta.name"
      description="publisher of the ressource"/>
    <column name="reference"  type="text"
      ucd="meta.ref"
      description="publication of reference"/>
    <column name="title"  type="text"
      ucd="meta.note"
      description="Title of the ressourcee"/>
    <column name="collection_id"  type="text"
      ucd="meta.id"
      description="IVOA ID of the collection"/>
    <column name="target_region"  type="text"
      ucd="meta.id;class"
      description="region of interest from a enumerated list"/>
    <column name="time_scale"  type="text" 
      ucd="time.scale" 
      description="time scale taken from STC"/>

</table>


 <data id="import">
    <make table="epn_core"/>
  </data>

<data id="collection" auto="false">
        <register services="__system__/tap#run"/>
        <make table="epn_core"/>
</data>
</resource>
