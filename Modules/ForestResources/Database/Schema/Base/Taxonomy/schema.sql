-- Contains forest resources and their meta-data
create schema "Taxonomy";

-- Entities
\include Taxonomy/entities/Species.sql

-- Relationships between entities
\include Taxonomy/foreign.keys.sql
