<?php

class Post
{
    private $db;
    private $table = 'posts';

    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Get posts
     */
    public function read()
    {
        $query = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at
                  FROM '.$this->table.' p
                  LEFT JOIN categories c ON p.category_id = c.id
                  ORDER BY p.created_at DESC';
    
        $statement = $this->db->prepare($query);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get single post  
     */
    public function read_single()
    {
        $query = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at
                  FROM '.$this->table.' p
                  LEFT JOIN categories c ON p.category_id = c.id
                  WHERE p.id = ?
                  LIMIT 0, 1';
    
        $statement = $this->db->prepare($query);
        $statement->bindParam(1, $this->id);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Create post  
     */
    public function create()
    {
        $query = 'INSERT INTO '.$this->table.'
                  SET title = :title, body = :body, author = :author, category_id = :category_id';
                  
        $statement = $this->db->prepare($query);

        // Clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        $statement->bindParam(':title', $this->title);
        $statement->bindParam(':body', $this->body);
        $statement->bindParam(':author', $this->author);
        $statement->bindParam(':category_id', $this->category_id);

        if ($statement->execute()) {
            return true;
        }

        //  Print error if something goes wrong
        printf("Error: %s.\n", $statement->error);

        return false;
    }
    
    /**
     * Update post  
     */
    public function update()
    {
        $query = 'UPDATE '.$this->table.'
                  SET title = :title, body = :body, author = :author, category_id = :category_id
                  WHERE id = :id';

        $statement = $this->db->prepare($query);

        // Clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $statement->bindParam(':title', $this->title);
        $statement->bindParam(':body', $this->body);
        $statement->bindParam(':author', $this->author);
        $statement->bindParam(':category_id', $this->category_id);
        $statement->bindParam(':id', $this->id);

        if ($statement->execute()) {
            return true;
        }

        //  Print error if something goes wrong
        printf("Error: %s.\n", $statement->error);

        return false;
    }

    /**
     * Delete post
     */
    public function delete()
    {
        $query = 'DELETE FROM '.$this->table.'
                  WHERE id = :id';

        $statement = $this->db->prepare($query);
        
        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));  

        $statement->bindParam(':id', $this->id);

        if ($statement->execute()) {
            return true;
        }

        //  Print error if something goes wrong
        printf("Error: %s.\n", $statement->error);

        return false;
    }
}