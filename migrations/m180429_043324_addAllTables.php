<?php

use yii\db\Migration;


/*
 *  don't forget up to RBAC migration
 */
/**
 * Class m180429_043324_addAllTables
 */
class m180429_043324_addAllTables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        try {
            $this->createTable('users', [
                'id' => $this->primaryKey()->comment('Первичный ключ'),
                'login' => $this->string(255)->notNull()->unique(),
                'password' => $this->string()->notNull(),
                'image' => $this->string(255),
                'selfdescription' => $this->text()->notNull(),
                'date_reg'=>$this->dateTime()->notNull()
            ]);

            $this->createTable('notes', [
                'id' => $this->primaryKey()->comment('Первичный ключ'),
                'id_owner' => $this->integer()->notNull(),
                'id_user' => $this->integer()->notNull(),
                'text' => $this->text()
            ]);

            $this->createTable('products', [
                'id' => $this->primaryKey()->comment('Первичный ключ'),
                'id_category'=> $this->integer()->notNull(),
                'title' => $this->string(255)->notNull()->unique(),
                'preview' => $this->string(),
                'description' => $this->text(),
                'image' => $this->string()->notNull(),
            ]);

            $this->createTable('category', [
                'id' => $this->primaryKey()->comment('Первичный ключ'),
                'title' => $this->string(255)->notNull()->unique(),
            ]);

            $this->insert('category',
                [
                    'title' =>"Nvidia",
                ]
            );

            $this->insert('category',
                [
                    'title' =>"AMD",
                ]
            );


            $this->createTable('comments', [
                'id' => $this->primaryKey()->comment('Первичный ключ'),
                'id_product' => $this->integer()->notNull(),
                'id_user' => $this->integer()->notNull(),
                'text' => $this->text(),
                'datetime' => $this->dateTime()
            ]);


            $this->addForeignKey("comments-product", "comments", "id_product", "products",
                "id", "CASCADE", "CASCADE");

            $this->addForeignKey("category-product", "products", "id_category", "category",
                "id", "CASCADE", "CASCADE");

            $this->addForeignKey("comments-user", "comments", "id_user", "users",
                "id", "CASCADE", "CASCADE");

            $this->addForeignKey("notes-owner", "notes", "id_owner", "users",
                "id", "CASCADE", "CASCADE");

            $this->addForeignKey("notes-user", "notes", "id_user", "users",
                "id", "CASCADE", "CASCADE");

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        try {
            $this->dropTable("notes");
            $this->dropTable("comments");
            $this->dropTable("users");
            $this->dropTable("category");
            $this->dropTable("products");

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180429_043324_addAllTables cannot be reverted.\n";

        return false;
    }
    */
}
