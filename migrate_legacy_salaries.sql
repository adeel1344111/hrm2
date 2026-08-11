-- Migration Script: Legacy Salaries to Salaries Table
-- Prerequisite:
-- 1. 'employee' table (employee.sql) must exist.
-- 2. 'emp_salary' table (emp_salary.sql) must be imported.
-- 3. 'users' table must be populated (migrate_legacy_users.sql executed).

-- CRITICAL: Ensure columns allowed specific NULLs to represent "empty"
-- Modify columns to be nullable if they aren't already
ALTER TABLE salaries MODIFY effective_date DATE NULL;
ALTER TABLE salaries MODIFY created_at TIMESTAMP NULL DEFAULT NULL;
ALTER TABLE salaries MODIFY updated_at TIMESTAMP NULL DEFAULT NULL;

-- CRITICAL: Start fresh
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE salaries;
SET FOREIGN_KEY_CHECKS = 1;

-- 1. Insert CURRENT Active Salary
INSERT INTO salaries (
    employee_id,
    basic_salary,
    punctuality,
    status,
    effective_date,
    created_at,
    updated_at
)
SELECT
    u.id,
    es.basic_salary,
    es.punctuality,
    'active',
    -- Use last_updated raw (if NULL, insert NULL)
    es.last_updated,
    -- Use last_updated for timestamps (if NULL, insert NULL)
    es.last_updated,
    es.last_updated
FROM emp_salary es
JOIN employee e ON es.emp_id = e.em_id
JOIN users u ON e.em_code = u.employee_id;

-- 2. Insert PREVIOUS Inactive Salary (History)
-- Only if last_salary or last_punctuality has data
INSERT INTO salaries (
    employee_id,
    basic_salary,
    punctuality,
    status,
    end_date,
    effective_date,
    created_at,
    updated_at
)
SELECT
    u.id,
    COALESCE(es.last_salary, 0),
    COALESCE(es.last_punctuality, 0),
    'inactive',
    es.last_updated, -- Ended at last update
    NULL, -- Effective date unknown/empty
    es.last_updated,
    es.last_updated
FROM emp_salary es
JOIN employee e ON es.emp_id = e.em_id
JOIN users u ON e.em_code = u.employee_id
WHERE (es.last_salary IS NOT NULL AND es.last_salary > 0)
   OR (es.last_punctuality IS NOT NULL AND es.last_punctuality > 0);
