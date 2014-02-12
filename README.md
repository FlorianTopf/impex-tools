impex-tools
============

IMPEx tools are a collection of scripts needed in the development phase
of the project

AsciiToVotable.php
------------------

simple tool for conversion of ASCII files into VOTable 1.2 files.
currently only manual table headers are supported.


IMPExToEPN.php
--------------

simple converter for data trees based on the IMPEx DM into 
EPNCore resources.

EPNCore resources can be either inserted in PostgreSQL or MySQL instances.

IMPEx DM MeasurementType to UCD conversion for EPNCore:
activityIndex		    => meta.code;phys.magfield
current				      => phys.elecCurrent
dopplergram			    => spect.doppler.velocity
dust				        => phys.particle.dust
electricfield		    => phys.elecField
energeticparticles	=> phys.particle
ephemeris			      => pos.bodyrc,
imageintensity		  => phot.flux;obs.image
instrumentstatus    => instr.setup;meta.code.status
ioncomposition		  => phys.atmol.ionStage
irradiance			    => phot.flux
magneticfield		    => phys.magField
magnetogram			    => phys.magField;obs.image
neutralatomimages	  => phys.atmol;obs.image
neutralgas			    => phys.atmol
radiance			      => phot.flux.density
spectrum			      => spect
thermalplasma		    => phys.particle
wave				        => em.radio
wave.active			    => em.radio
wave.passive		    => em.radio

IMPEx DM SimulationProdoct to EPNCore dataproduct_type conversion:

3dcubes			  => vo
2dcuts			  => im
timeseries		=> ts
spatialseries	=> sv
lines			    => sv
spectra			  => ds or sp


TODO
----
- multiple trees per database are not supported at the moment
- instrument_name and instrument_host_name are mixed up in conversion
