<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInscritosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'nombres' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'apellidos' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'cedula' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'fecha_nacimiento' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'genero' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'celular' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'nombre_farmacia' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'ciudad' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'direccion_farmacia' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'nombre_cadena_distribuidor' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'acepta_politica_datos' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'registration_date' => [
                'type'    => 'TIMESTAMP',
                'null'    => false,
            ],
            'status' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->createTable('inscritos');

        // Ensure the column has a proper database CURRENT_TIMESTAMP default
        // Use raw SQL because Forge may escape the string 'CURRENT_TIMESTAMP'.
        $this->db->simpleQuery("ALTER TABLE `inscritos` MODIFY `registration_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;");
    }

    public function down()
    {
        $this->forge->dropTable('inscritos');
    }
}
