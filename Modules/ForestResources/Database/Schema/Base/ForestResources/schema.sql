-- Contains forest resources and their meta-data
create schema "ForestResources";

-- Entities
\include entities/BaseResources.sql
\include entities/ResourceTypes.sql

\include entities/AnnualAllowableCuts.sql
\include entities/AnnualOperationPlans.sql
\include entities/ConstituentPermits.sql
\include entities/Concessions.sql
\include entities/DevelopmentPlans.sql
\include entities/DevelopmentUnits.sql
\include entities/ManagementPlans.sql
\include entities/ManagementUnits.sql
\include entities/PermitTypes.sql
\include entities/Parcels.sql
\include entities/InventoryQualities.sql
\include entities/AnnualAllowableCutInventory.sql

\include views/schema.sql

-- Relationships between entities
\include foreign.keys.sql

-- DATA
\include ForestResources.data.sql
