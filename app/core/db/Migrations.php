<?php

namespace app\core\db;

use app\core\Application;
use PDO;

/**
 * Class Migrations
 */
class Migrations
{
    protected Database $db;

    /**
     * Start migrations
     */
    protected function applyMigrations(Database $db)
    {
        $this->db = $db;

        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();

        $newMigrations = [];
        $files = scandir(Application::$rootDir . '/migrations');
        $toApplyMigrations = array_diff($files, $appliedMigrations);
        foreach ($toApplyMigrations as $migration) {
            if ($migration === '.' || $migration === '..') {
                continue;
            }

            require_once Application::$rootDir . '/migrations/' . $migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className();
            $this->log("Миграция $migration создана");
            $instance->up();
            $this->log("Миграция $migration применена");
            $newMigrations[] = $migration;
        }

        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            $this->log("Все миграции были загружены");
        }
    }

    /**
     * Create table migrations
     * @param PDO|null $pdo
     */
    protected function createMigrationsTable()
    {
        $this->db::query("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )  ENGINE=INNODB;");
    }

    /**
     * Get migrations
     * @return mixed
     */
    protected function getAppliedMigrations()
    {
        return $this->db::getAll("SELECT migration FROM migrations");
    }

    /**
     * Save migrations
     * @param array $newMigrations
     */
    protected function saveMigrations(array $newMigrations)
    {
        $str = implode(',', array_map(fn($m) => "('$m')", $newMigrations));
        $this->db::query("INSERT INTO migrations (migration) VALUES 
            $str
        ");
    }

    /**
     * Show log in console
     * @param string $message
     */
    private function log(string $message)
    {
        echo "[" . date("Y-m-d H:i:s") . "] - " . $message . PHP_EOL;
    }
}