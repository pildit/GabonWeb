-- Contains forest resources and their meta-data
create schema "ForestResources";

-- Entities
\include ForestResources/entities/BaseResources.sql
\include ForestResources/entities/ResourceTypes.sql

\include ForestResources/entities/AnnualAllowableCuts.sql
\include ForestResources/entities/AnnualOperationPlans.sql
\include ForestResources/entities/ConstituentPermits.sql
\include ForestResources/entities/Concessions.sql
\include ForestResources/entities/DevelopmentPlans.sql
\include ForestResources/entities/DevelopmentUnits.sql
\include ForestResources/entities/ManagementPlans.sql
\include ForestResources/entities/ManagementUnits.sql
\include ForestResources/entities/PermitTypes.sql
\include ForestResources/entities/Parcels.sql
\include ForestResources/entities/InventoryQualities.sql
\include ForestResources/entities/AnnualAllowableCutInventory.sql

\include ForestResources/views/schema.sql

-- Relationships between entities
\include ForestResources/foreign.keys.sql

-- DATA
\include ForestResources.data.sql
