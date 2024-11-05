
DROP PROCEDURE IF EXISTS `p_gen_std_entity_id`;

-- DROP TABLE IF EXISTS `t_ident_std_entity`;

CREATE TABLE IF NOT EXISTS `t_ident_std_entity` (
  `a_std_entity_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `a_std_entity_created_in` INT NOT NULL,
  `a_std_entity_created_on` TIMESTAMP(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `a_std_entity_updated_on` TIMESTAMP(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)
ENGINE=InnoDB COLLATE=utf8mb4_unicode_520_ci;

CREATE TABLE IF NOT EXISTS `t_test_id` (
  `a_std_entity_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY
)
ENGINE=InnoDB COLLATE=utf8mb4_unicode_520_ci;

CREATE TABLE IF NOT EXISTS `t_test_id8` (
  `a_std_entity_id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY
)
ENGINE=InnoDB COLLATE=utf8mb4_unicode_520_ci;

DELIMITER $$

CREATE PROCEDURE `p_gen_std_entity_id` (
    IN a_std_interaction_id INT,
    IN n INT
)
BEGIN

    DROP TEMPORARY TABLE IF EXISTS `t_tmp_entity_id`;

    CREATE TEMPORARY TABLE `t_tmp_entity_id` (
        a_std_entity_id INT NOT NULL PRIMARY KEY
    )
    ENGINE=MEMORY MIN_ROWS=32 MAX_ROWS=1024;

    SET @i = 0;
    SET @limit = 1024;
    SET @old_autocommit = ( SELECT @@autocommit );

    SET autocommit = 0;

    REPEAT

        INSERT
            INTO `t_ident_std_entity` ( `a_std_entity_created_in` )
            VALUES ( a_std_interaction_id );

        INSERT
            INTO `t_tmp_entity_id`
            VALUES ( LAST_INSERT_ID() );

        SET @i = @i + 1;

        UNTIL @i >= n OR @i >= @limit

    END REPEAT;

    COMMIT WORK;

    SET autocommit = @old_autocommit;

    SELECT a_std_entity_id FROM `t_tmp_entity_id`;

    DROP TEMPORARY TABLE `t_tmp_entity_id`;

END $$

DELIMITER ;
