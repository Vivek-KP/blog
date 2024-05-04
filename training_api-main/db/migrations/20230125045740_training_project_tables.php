<?php


use Phinx\Migration\AbstractMigration;

class TrainingProjectTables extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
      // write your SQL inside the double quotes
      $this->execute("
      CREATE TABLE users(
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(255) NOT NULL,
        password VARCHAR(32) NOT NULL,
        created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
        updated_date TIMESTAMP DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
        created_by INT NOT NULL,
        FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE,
        updated_by INT NULL,
        FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE CASCADE
      );
        
        
      CREATE TABLE posts(
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        title VARCHAR(255) NOT NULL,
        content VARCHAR(255) NOT NULL,
        user_id INT NOT NULL,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
        updated_date TIMESTAMP DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
        created_by INT NOT NULL,
        FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE,
        updated_by INT NULL,
        FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE CASCADE
      );


      CREATE TABLE comments(
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        comment VARCHAR(255) NOT NULL,
        user_id INT NOT NULL,
        post_id INT NOT NULL,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
        created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
        updated_date TIMESTAMP DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
        created_by INT NOT NULL,
        updated_by INT NULL,
        FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE CASCADE
      );
          
      ");
    }
}
