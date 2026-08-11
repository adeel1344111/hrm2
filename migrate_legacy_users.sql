-- Migration Script: Legacy Employees to Users
-- Prerequisite: Ensure the 'employee' table (from employee.sql) exists in the database.

-- CRITICAL: Truncate users table to remove data from previous incorrect migration runs
-- This ensures we don't have duplicate users (one with em_id and one with em_code)
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE users;
SET FOREIGN_KEY_CHECKS = 1;

INSERT INTO users (
    name,
    password,
    user_type,
    employee_id,
    contact_number,
    emergency_contact,
    cnic,
    appointment_date,
    profile_picture,
    left_date,
    department,
    designation,
    status
)
SELECT
    CONCAT(first_name, ' ', last_name) AS name,
    em_password AS password,
    CASE em_role
        WHEN 'ADMIN' THEN 'admin'
        WHEN 'FLOOR MANAGER' THEN 'floor_manager'
        WHEN 'TEAM LEAD' THEN 'team_lead'
        WHEN 'AGENT' THEN 'agent'
        WHEN 'MANAGEMENT' THEN 'agent' -- Mapping MANAGEMENT to agent as requested
        ELSE 'agent'
    END AS user_type,
    em_code AS employee_id, -- CHANGED: Using em_code as employee_id
    em_phone AS contact_number,
    emergency_contact AS emergency_contact,
    em_nid AS cnic,
    CASE WHEN em_appointment_date = '0000-00-00' OR em_appointment_date = '' THEN NULL ELSE em_appointment_date END AS appointment_date,
    NULL, -- profile picture,
    NULLIF(em_contact_end, '') AS left_date,
    'Sales' AS department,
    CASE des_id 
        WHEN 32 THEN 'CSR' 
        WHEN 34 THEN 'Verification Officer' 
        ELSE NULL 
    END AS designation,
    LOWER(status) AS status
FROM employee
ON DUPLICATE KEY UPDATE
    name = VALUES(name),
    password = VALUES(password),
    user_type = VALUES(user_type),
    contact_number = VALUES(contact_number),
    emergency_contact = VALUES(emergency_contact),
    cnic = VALUES(cnic),
    appointment_date = VALUES(appointment_date),
    profile_picture = VALUES(profile_picture),
    left_date = VALUES(left_date),
    department = VALUES(department),
    designation = VALUES(designation),
    status = VALUES(status);

-- Update team_lead_id relationships
-- Logic: 
-- 1. Match current user to legacy employee (via em_code)
-- 2. Find legacy team lead (via employee.team_lead_id -> employee.em_id)
-- 3. Find user record for that legacy team lead (via em_code)
-- 4. Update the user's team_lead_id with the found user id
UPDATE users u
JOIN employee e ON u.employee_id = e.em_code
LEFT JOIN employee tl_emp ON e.team_lead_id = tl_emp.em_id
LEFT JOIN users tl_user ON tl_emp.em_code = tl_user.employee_id
SET u.team_lead_id = tl_user.id
WHERE tl_user.id IS NOT NULL;
