<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get all accounts - Updated with all fields needed for index
        DB::unprepared('
            DROP PROCEDURE IF EXISTS spGetAllAccounts;
            CREATE PROCEDURE spGetAllAccounts()
            BEGIN
                SELECT 
                    u.id,
                    u.first_name,
                    u.middle_name,
                    u.last_name,
                    CONCAT(u.first_name, \' \', IFNULL(u.middle_name, \'\'), \' \', u.last_name) AS full_name,
                    u.birth_date,
                    u.username,
                    u.is_logged_in,
                    u.logged_in_at,
                    u.logged_out_at,
                    u.is_active,
                    u.note,
                    u.created_at
                FROM users u
                ORDER BY u.id DESC;
            END
        ');

        // Get account by ID
        DB::unprepared('
        DROP PROCEDURE IF EXISTS spGetAccountById;
            CREATE PROCEDURE spGetAccountById(IN accountId INT)
            BEGIN
                SELECT 
                    u.id,
                    u.first_name,
                    u.middle_name,
                    u.last_name,
                    CONCAT(u.first_name, \' \', IFNULL(u.middle_name, \'\'), \' \', u.last_name) AS full_name,
                    u.birth_date,
                    u.username,
                    u.is_logged_in,
                    u.logged_in_at,
                    u.logged_out_at,
                    u.is_active,
                    u.note,
                    u.created_at,
                    c.street,
                    c.house_number,
                    c.addition,
                    c.postal_code,
                    c.city,
                    c.mobile,
                    c.email
                FROM users u
                LEFT JOIN contacts c ON u.id = c.user_id
                WHERE u.id = accountId;
            END
        ');

        // Add new account - Updated to handle both user and contact info
        DB::unprepared('
        DROP PROCEDURE IF EXISTS spAddAccount;
            CREATE PROCEDURE spAddAccount(
                IN p_first_name VARCHAR(255),
                IN p_middle_name VARCHAR(255),
                IN p_last_name VARCHAR(255),
                IN p_birth_date DATE,
                IN p_username VARCHAR(255),
                IN p_password VARCHAR(255),
                IN p_is_active BOOLEAN,
                IN p_note TEXT,
                IN p_email VARCHAR(255),
                IN p_mobile VARCHAR(20),
                IN p_street VARCHAR(255),
                IN p_house_number VARCHAR(10),
                IN p_addition VARCHAR(10),
                IN p_postal_code VARCHAR(10),
                IN p_city VARCHAR(255)
            )
            BEGIN
                DECLARE last_user_id INT;
                
                -- Insert user account
                INSERT INTO users (
                    first_name, 
                    middle_name, 
                    last_name, 
                    birth_date, 
                    username, 
                    password, 
                    is_active, 
                    note,
                    created_at,
                    updated_at
                )
                VALUES (
                    p_first_name, 
                    p_middle_name, 
                    p_last_name, 
                    p_birth_date, 
                    p_username, 
                    p_password, 
                    p_is_active, 
                    p_note,
                    NOW(),
                    NOW()
                );
                
                -- Get the inserted user ID
                SET last_user_id = LAST_INSERT_ID();
                
                -- Insert contact information if any provided
                IF p_email IS NOT NULL OR p_mobile IS NOT NULL OR p_street IS NOT NULL OR 
                   p_house_number IS NOT NULL OR p_postal_code IS NOT NULL OR p_city IS NOT NULL THEN
                    
                    INSERT INTO contacts (
                        user_id,
                        email,
                        mobile,
                        street,
                        house_number,
                        addition,
                        postal_code,
                        city,
                        created_at,
                        updated_at
                    )
                    VALUES (
                        last_user_id,
                        p_email,
                        p_mobile,
                        p_street,
                        p_house_number,
                        p_addition,
                        p_postal_code,
                        p_city,
                        NOW(),
                        NOW()
                    );
                END IF;
                
                -- Return the user ID
                SELECT last_user_id AS user_id;
            END
        ');

        // Update account
        DB::unprepared('
        DROP PROCEDURE IF EXISTS spUpdateAccount;
            CREATE PROCEDURE spUpdateAccount(
                IN p_user_id INT,
                IN p_first_name VARCHAR(255),
                IN p_middle_name VARCHAR(255),
                IN p_last_name VARCHAR(255),
                IN p_birth_date DATE,
                IN p_username VARCHAR(255),
                IN p_password VARCHAR(255),
                IN p_is_active BOOLEAN,
                IN p_note TEXT
            )
            BEGIN                
                UPDATE users 
                SET first_name = p_first_name,
                    middle_name = p_middle_name,
                    last_name = p_last_name,
                    birth_date = p_birth_date,
                    username = p_username,
                    password = CASE WHEN p_password IS NOT NULL AND p_password != \'\' THEN p_password ELSE password END,
                    is_active = p_is_active,
                    note = p_note,
                    updated_at = NOW()
                WHERE id = p_user_id;
            END
        ');

        // Delete account
        DB::unprepared('
        DROP PROCEDURE IF EXISTS spDeleteAccount;
            CREATE PROCEDURE spDeleteAccount(IN accountId INT)
            BEGIN                
                -- Delete contact information first to maintain referential integrity
                DELETE FROM contacts WHERE user_id = accountId;
                
                -- Then delete the user account
                DELETE FROM users WHERE id = accountId;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS spGetAllAccounts;');
        DB::unprepared('DROP PROCEDURE IF EXISTS spGetAccountById;');
        DB::unprepared('DROP PROCEDURE IF EXISTS spAddAccount;');
        DB::unprepared('DROP PROCEDURE IF EXISTS spUpdateAccount;');
        DB::unprepared('DROP PROCEDURE IF EXISTS spDeleteAccount;');
    }
};