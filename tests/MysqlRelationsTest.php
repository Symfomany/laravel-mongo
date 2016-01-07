<?php
class MysqlRelationsTest extends BaseTestCase {
    public function setUp()
    {
        parent::setUp();
        MysqlUser::executeSchema();
        MysqlBook::executeSchema();
        MysqlRole::executeSchema();
    }
    public function tearDown()
    {
        MysqlUser::truncate();
        MysqlBook::truncate();
        MysqlRole::truncate();
        Book::truncate();
        parent::tearDown();
    }
    public function testMysqlRelations()
    {
        $user = new MysqlUser;
        $this->assertInstanceOf('MysqlUser', $user);
//        exit(dump(get_class($user->getConnection())));
        $this->assertInstanceOf('Illuminate\Database\MySqlConnection', $user->getConnection());

        // Mysql User
        $user->name = "John Doe";
        $user->save();
        $this->assertTrue(is_int($user->id));


        // SQL has many
        $book = new Book(['title' => 'Game of Thrones']);
        $book2 = new Book(['title' => 'Games of Thrones 2']);
        $user->books()->saveMany([$book, $book2]);

        $user = MysqlUser::find($user->id); // refetch
        $this->assertGreaterThanOrEqual(2, count($user->books));


        // MongoDB belongs to
        $book = $user->books()->first(); // refetch
        $this->assertEquals('John Doe', $book->mysqlAuthor->name);
        // SQL has one
        $role = new Role(['type' => 'admin']);
        $user->role()->save($role);
        $user = MysqlUser::find($user->id); // refetch
        $this->assertEquals('admin', $user->role->type);
        // MongoDB belongs to
        $role = $user->role()->first(); // refetch
        $this->assertEquals('John Doe', $role->mysqlUser->name);

        // MongoDB User
        $user = new User;
        $user->name = "John Doe";
        $user->save();

        // MongoDB has many
        $book = new MysqlBook(['title' => 'Game of Thrones']);
        $book2 = new MysqlBook(['title' => 'Game of Thrones 2']);
        $user->mysqlBooks()->saveMany([$book, $book2]);

        $user = User::find($user->_id); // refetch
        $this->assertEquals(2, $user->mysqlBooks->count());

        // SQL belongs to
        $book = $user->mysqlBooks()->first(); // refetch

        $this->assertEquals('John Doe', $book->author->name);
        // MongoDB has one
        $role = new MysqlRole(['type' => 'admin']);
        $user->mysqlRole()->save($role);
        $user = User::find($user->_id); // refetch
        $this->assertEquals('admin', $user->mysqlRole->type);
        // SQL belongs to
        $role = $user->mysqlRole()->first(); // refetch
        $this->assertEquals('John Doe', $role->user->name);
    }
}