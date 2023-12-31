<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        $procedure = '
            CREATE PROCEDURE SelectSaleList (IN fromDate VARCHAR(50), IN toDate VARCHAR(50))
            BEGIN
                SELECT
                    sales.SId,
                    sales.SDate,
                    products.productname,
                    cutomer_type.stand_for,
                    users.NAME,
                    SUM(sales.qty) AS total_quantity,
                    SUM(sales.qty * products.productprice) AS total_amount,
                    sales.discount,
                    customers.customer_name
                FROM sales
                    LEFT OUTER JOIN products ON sales.product_id = products.id
                    LEFT OUTER JOIN cutomer_type ON sales.customer_id = cutomer_type.id
                    LEFT OUTER JOIN customers ON sales.particular_client = customers.id
                    LEFT OUTER JOIN users ON sales.user_id = users.id
                WHERE
                    sales.SDate BETWEEN CAST(fromDate AS DATETIME) AND CAST(toDate AS DATETIME)
                GROUP BY
                    sales.SId;
            END
        ';

        DB::unprepared("DROP PROCEDURE IF EXISTS SelectSaleList");
        DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SelectSaleList");
    }
};
