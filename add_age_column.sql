-- Add age column to csr_submissions table
ALTER TABLE `csr_submissions` ADD COLUMN `age` INT NULL AFTER `zip_code`;
