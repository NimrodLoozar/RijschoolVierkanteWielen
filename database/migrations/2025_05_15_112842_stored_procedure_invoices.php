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
        // Ophalen van alle facturen met volledige gegevens
        DB::unprepared('
          DROP PROCEDURE IF EXISTS spGetAllInvoices;
            CREATE PROCEDURE spGetAllInvoices()
            BEGIN
                SELECT 
                    i.id, i.invoice_number, i.invoice_date, i.status,
                    i.amount_excl_vat, i.vat, i.amount_incl_vat, i.note,
                    r.id AS registration_id, r.start_date, r.end_date,
                    r.student_id, s.relation_number AS student_relation_number, s.is_active AS student_is_active,
                    CONCAT(u.first_name, \' \', u.last_name) AS student_name,
                    r.package_id, p.type AS package_type, p.lesson_count, p.price_per_lesson,
                    i.created_at, i.updated_at, i.is_active
                FROM invoices i
                JOIN registrations r ON i.registration_id = r.id
                JOIN students s ON r.student_id = s.id
                JOIN users u ON s.user_id = u.id
                JOIN packages p ON r.package_id = p.id
                ORDER BY i.id DESC;
            END;
        ');

        // Ophalen van een specifieke factuur op ID
        DB::unprepared('
            DROP PROCEDURE IF EXISTS spGetInvoiceById;
            CREATE PROCEDURE spGetInvoiceById(IN invoice_id INT)
            BEGIN
                SELECT 
                    i.id, i.invoice_number, i.invoice_date, i.status,
                    i.amount_excl_vat, i.vat, i.amount_incl_vat, i.note,
                    r.id AS registration_id, r.start_date, r.end_date,
                    r.student_id, s.relation_number AS student_relation_number, s.is_active AS student_is_active,
                    CONCAT(u.first_name, \' \', u.last_name) AS student_name,
                    r.package_id, p.type AS package_type, p.lesson_count, p.price_per_lesson,
                    i.created_at, i.updated_at, i.is_active
                FROM invoices i
                JOIN registrations r ON i.registration_id = r.id
                JOIN students s ON r.student_id = s.id
                JOIN users u ON s.user_id = u.id
                JOIN packages p ON r.package_id = p.id
                WHERE i.id = invoice_id;
            END;
        ');

        // Toevoegen van een factuur
        DB::unprepared('
            DROP PROCEDURE IF EXISTS spAddInvoice;
            CREATE PROCEDURE spAddInvoice(
                IN p_invoice_number VARCHAR(255),
                IN p_invoice_date DATE, 
                IN p_status VARCHAR(50), 
                IN p_amount_excl_vat DECIMAL(10,2), 
                IN p_vat DECIMAL(10,2), 
                IN p_amount_incl_vat DECIMAL(10,2), 
                IN p_note TEXT, 
                IN p_registration_id INT,
                IN p_is_active BOOLEAN
            )
            BEGIN
                INSERT INTO invoices (
                    invoice_number, invoice_date, status, 
                    amount_excl_vat, vat, amount_incl_vat, 
                    note, registration_id, is_active,
                    created_at, updated_at
                )
                VALUES (
                    p_invoice_number, p_invoice_date, p_status, 
                    p_amount_excl_vat, p_vat, p_amount_incl_vat, 
                    p_note, p_registration_id, p_is_active,
                    NOW(), NOW()
                );
                
                -- Return the newly created invoice with all associated data
                SELECT 
                    i.id, i.invoice_number, i.invoice_date, i.status,
                    i.amount_excl_vat, i.vat, i.amount_incl_vat, i.note,
                    r.id AS registration_id, r.start_date, r.end_date,
                    r.student_id, s.relation_number AS student_relation_number, s.is_active AS student_is_active,
                    CONCAT(u.first_name, \' \', u.last_name) AS student_name,
                    r.package_id, p.type AS package_type, p.lesson_count, p.price_per_lesson,
                    i.created_at, i.updated_at, i.is_active
                FROM invoices i
                JOIN registrations r ON i.registration_id = r.id
                JOIN students s ON r.student_id = s.id
                JOIN users u ON s.user_id = u.id
                JOIN packages p ON r.package_id = p.id
                WHERE i.invoice_number = p_invoice_number
                ORDER BY i.id DESC
                LIMIT 1;
            END
        ');

        // Updaten van een factuur
        DB::unprepared('
            DROP PROCEDURE IF EXISTS spUpdateInvoice;
            CREATE PROCEDURE spUpdateInvoice(
                IN p_invoice_id INT,
                IN p_invoice_number VARCHAR(255), 
                IN p_invoice_date DATE, 
                IN p_status VARCHAR(50), 
                IN p_amount_excl_vat DECIMAL(10,2), 
                IN p_vat DECIMAL(10,2), 
                IN p_amount_incl_vat DECIMAL(10,2), 
                IN p_note TEXT,
                IN p_is_active BOOLEAN
            )
            BEGIN
                UPDATE invoices 
                SET invoice_number = p_invoice_number,
                    invoice_date = p_invoice_date, 
                    status = p_status, 
                    amount_excl_vat = p_amount_excl_vat, 
                    vat = p_vat, 
                    amount_incl_vat = p_amount_incl_vat, 
                    note = p_note,
                    is_active = p_is_active,
                    updated_at = NOW()
                WHERE id = p_invoice_id;
                
                -- Return the updated invoice with all associated data
                SELECT 
                    i.id, i.invoice_number, i.invoice_date, i.status,
                    i.amount_excl_vat, i.vat, i.amount_incl_vat, i.note,
                    r.id AS registration_id, r.start_date, r.end_date,
                    r.student_id, s.relation_number AS student_relation_number, s.is_active AS student_is_active,
                    CONCAT(u.first_name, \' \', u.last_name) AS student_name,
                    r.package_id, p.type AS package_type, p.lesson_count, p.price_per_lesson,
                    i.created_at, i.updated_at, i.is_active
                FROM invoices i
                JOIN registrations r ON i.registration_id = r.id
                JOIN students s ON r.student_id = s.id
                JOIN users u ON s.user_id = u.id
                JOIN packages p ON r.package_id = p.id
                WHERE i.id = p_invoice_id;
            END
        ');

        // Verwijderen van een factuur
        DB::unprepared('
            DROP PROCEDURE IF EXISTS spDeleteInvoice;
            CREATE PROCEDURE spDeleteInvoice(IN invoice_id INT)
            BEGIN
                DELETE FROM invoices WHERE id = invoice_id;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS spGetAllInvoices');
        DB::unprepared('DROP PROCEDURE IF EXISTS spGetInvoiceById');
        DB::unprepared('DROP PROCEDURE IF EXISTS spAddInvoice');
        DB::unprepared('DROP PROCEDURE IF EXISTS spUpdateInvoice');
        DB::unprepared('DROP PROCEDURE IF EXISTS spDeleteInvoice');
    }
};