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
                    u.created_at
                FROM users u
                WHERE u.id = accountId;
            END
        ');

        // Add new account
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
                IN p_note TEXT
            )
            BEGIN                
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