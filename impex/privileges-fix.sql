GRANT ALL ON SCHEMA impex_sim_trees TO gavo WITH GRANT OPTION;
GRANT ALL ON SCHEMA impex_sim_trees TO gavoadmin WITH GRANT OPTION;
GRANT USAGE ON SCHEMA impex_sim_trees TO untrusted;

GRANT ALL ON TABLE impex_sim_trees.epn_core TO gavoadmin WITH GRANT OPTION;
GRANT ALL ON TABLE impex_sim_trees.epn_core TO gavo WITH GRANT OPTION;
GRANT SELECT ON TABLE impex_sim_trees.epn_core TO untrusted;