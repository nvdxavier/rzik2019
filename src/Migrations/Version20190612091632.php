<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190612091632 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE article_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE artist_band_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE member_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE musicfile_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE picture_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE playlist_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE playlist_project_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tag_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE article (id INT NOT NULL, member_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, content TEXT DEFAULT NULL, tag VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_23A0E667597D3FE ON article (member_id)');
        $this->addSql('CREATE TABLE artist_band (id INT NOT NULL, artistbandmember_id INT DEFAULT NULL, artistbandname VARCHAR(255) NOT NULL, artistbanddescription TEXT DEFAULT NULL, artistbanddateceation DATE DEFAULT NULL, artistbandfacebook VARCHAR(255) DEFAULT NULL, artistbandtwitter VARCHAR(255) DEFAULT NULL, artistbandinstagram VARCHAR(255) DEFAULT NULL, artistbandcountry VARCHAR(255) DEFAULT NULL, artistbandcity VARCHAR(255) DEFAULT NULL, artistbandcategory VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F461247429D65BB8 ON artist_band (artistbandmember_id)');
        $this->addSql('CREATE TABLE member (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(100) DEFAULT NULL, lastname VARCHAR(100) DEFAULT NULL, reset_token VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_70E4FA78E7927C74 ON member (email)');
        $this->addSql('CREATE TABLE musicfile (id INT NOT NULL, playlistproject_id INT DEFAULT NULL, filename VARCHAR(255) NOT NULL, filedate TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, filetitle VARCHAR(255) NOT NULL, fileartist VARCHAR(255) DEFAULT NULL, filecategory VARCHAR(255) DEFAULT NULL, fileposition VARCHAR(255) DEFAULT NULL, fileduration INT DEFAULT NULL, filetransfertdate TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2EA79D1C680F7EA2 ON musicfile (playlistproject_id)');
        $this->addSql('CREATE TABLE picture (id INT NOT NULL, memberowner_id INT DEFAULT NULL, pictureartistband_id INT DEFAULT NULL, logoartistband_id INT DEFAULT NULL, playlistproject_id INT DEFAULT NULL, plprojectowner_id INT DEFAULT NULL, picturename VARCHAR(255) DEFAULT NULL, position INT DEFAULT NULL, picturefile VARCHAR(255) DEFAULT NULL, picturecategory TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_16DB4F89B5803710 ON picture (memberowner_id)');
        $this->addSql('CREATE INDEX IDX_16DB4F89215C99C4 ON picture (pictureartistband_id)');
        $this->addSql('CREATE INDEX IDX_16DB4F89D6211311 ON picture (logoartistband_id)');
        $this->addSql('CREATE INDEX IDX_16DB4F89680F7EA2 ON picture (playlistproject_id)');
        $this->addSql('CREATE INDEX IDX_16DB4F897881EE87 ON picture (plprojectowner_id)');
        $this->addSql('COMMENT ON COLUMN picture.picturecategory IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE playlist (id INT NOT NULL, member_id INT DEFAULT NULL, plname VARCHAR(255) DEFAULT NULL, datecreatepl TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, position INT DEFAULT NULL, descriptionpl TEXT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D782112D7597D3FE ON playlist (member_id)');
        $this->addSql('CREATE TABLE playlist_music_file (playlist_id INT NOT NULL, music_file_id INT NOT NULL, PRIMARY KEY(playlist_id, music_file_id))');
        $this->addSql('CREATE INDEX IDX_7AFABD396BBD148 ON playlist_music_file (playlist_id)');
        $this->addSql('CREATE INDEX IDX_7AFABD39573FEB17 ON playlist_music_file (music_file_id)');
        $this->addSql('CREATE TABLE playlist_project (id INT NOT NULL, mainpictureplproject_id INT DEFAULT NULL, artistbandplproject_id INT DEFAULT NULL, plprojectname VARCHAR(255) NOT NULL, datecreateplproject TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, plprojectposition INT DEFAULT NULL, descriptionplproject TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_908CC7F4BE56BF0E ON playlist_project (mainpictureplproject_id)');
        $this->addSql('CREATE INDEX IDX_908CC7F47620A6E5 ON playlist_project (artistbandplproject_id)');
        $this->addSql('CREATE TABLE tag (id INT NOT NULL, tagname VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E667597D3FE FOREIGN KEY (member_id) REFERENCES member (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE artist_band ADD CONSTRAINT FK_F461247429D65BB8 FOREIGN KEY (artistbandmember_id) REFERENCES member (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE musicfile ADD CONSTRAINT FK_2EA79D1C680F7EA2 FOREIGN KEY (playlistproject_id) REFERENCES playlist_project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89B5803710 FOREIGN KEY (memberowner_id) REFERENCES member (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89215C99C4 FOREIGN KEY (pictureartistband_id) REFERENCES artist_band (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89D6211311 FOREIGN KEY (logoartistband_id) REFERENCES artist_band (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89680F7EA2 FOREIGN KEY (playlistproject_id) REFERENCES playlist_project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F897881EE87 FOREIGN KEY (plprojectowner_id) REFERENCES playlist_project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE playlist ADD CONSTRAINT FK_D782112D7597D3FE FOREIGN KEY (member_id) REFERENCES member (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE playlist_music_file ADD CONSTRAINT FK_7AFABD396BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE playlist_music_file ADD CONSTRAINT FK_7AFABD39573FEB17 FOREIGN KEY (music_file_id) REFERENCES musicfile (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE playlist_project ADD CONSTRAINT FK_908CC7F4BE56BF0E FOREIGN KEY (mainpictureplproject_id) REFERENCES picture (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE playlist_project ADD CONSTRAINT FK_908CC7F47620A6E5 FOREIGN KEY (artistbandplproject_id) REFERENCES artist_band (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE picture DROP CONSTRAINT FK_16DB4F89215C99C4');
        $this->addSql('ALTER TABLE picture DROP CONSTRAINT FK_16DB4F89D6211311');
        $this->addSql('ALTER TABLE playlist_project DROP CONSTRAINT FK_908CC7F47620A6E5');
        $this->addSql('ALTER TABLE article DROP CONSTRAINT FK_23A0E667597D3FE');
        $this->addSql('ALTER TABLE artist_band DROP CONSTRAINT FK_F461247429D65BB8');
        $this->addSql('ALTER TABLE picture DROP CONSTRAINT FK_16DB4F89B5803710');
        $this->addSql('ALTER TABLE playlist DROP CONSTRAINT FK_D782112D7597D3FE');
        $this->addSql('ALTER TABLE playlist_music_file DROP CONSTRAINT FK_7AFABD39573FEB17');
        $this->addSql('ALTER TABLE playlist_project DROP CONSTRAINT FK_908CC7F4BE56BF0E');
        $this->addSql('ALTER TABLE playlist_music_file DROP CONSTRAINT FK_7AFABD396BBD148');
        $this->addSql('ALTER TABLE musicfile DROP CONSTRAINT FK_2EA79D1C680F7EA2');
        $this->addSql('ALTER TABLE picture DROP CONSTRAINT FK_16DB4F89680F7EA2');
        $this->addSql('ALTER TABLE picture DROP CONSTRAINT FK_16DB4F897881EE87');
        $this->addSql('DROP SEQUENCE article_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE artist_band_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE member_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE musicfile_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE picture_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE playlist_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE playlist_project_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tag_id_seq CASCADE');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE artist_band');
        $this->addSql('DROP TABLE member');
        $this->addSql('DROP TABLE musicfile');
        $this->addSql('DROP TABLE picture');
        $this->addSql('DROP TABLE playlist');
        $this->addSql('DROP TABLE playlist_music_file');
        $this->addSql('DROP TABLE playlist_project');
        $this->addSql('DROP TABLE tag');
    }
}
