-- Make comment column nullable in both submission tables

ALTER TABLE `csr_submissions` 
MODIFY COLUMN `comment` TEXT NULL;

ALTER TABLE `verification_submissions` 
MODIFY COLUMN `comment` TEXT NULL;
