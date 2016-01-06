<?php
//
///**
// * Class RelationsTest
// */
//class RelationsTest extends BaseTestCase {
//
//    public function tearDown()
//    {
//        Mockery::close();
//        User::truncate();
//        Client::truncate();
//        Address::truncate();
//        Book::truncate();
//        Item::truncate();
//        Role::truncate();
//        Client::truncate();
//        Group::truncate();
//        Photo::truncate();
//    }
//
//
//    public function testHasMany()
//    {
//        $author = User::create(['name' => 'George R. R. Martin']);
//        $book1 = Book::create(['title' => 'A Game of Thrones', 'author_id' => $author->_id]);
//        $book2 = Book::create(['title' => 'A Clash of Kings', 'author_id' => $author->_id]);
//        $books = $author->book;
//        $this->assertEquals(2, $author->book()->count());
//        $user = User::create(['name' => 'John Doe']);
//        Item::create(['type' => 'knife', 'user_id' => $user->_id]);
//        Item::create(['type' => 'shield', 'user_id' => $user->_id]);
//        Item::create(['type' => 'sword', 'user_id' => $user->_id]);
//        Item::create(['type' => 'bag', 'user_id' => null]);
//        $items = $user->items;
//        $this->assertEquals(3, count($items));
//    }
//
//
//    public function testBelongsTo()
//    {
//        $user = User::create(['name' => 'George R. R. Martin']);
//        Book::create(['title' => 'A Game of Thrones', 'author_id' => $user->_id]);
//        $book = Book::create(['title' => 'A Clash of Kings', 'author_id' => $user->_id]);
//        $author = $book->author;
//        $this->assertEquals('George R. R. Martin', $author->name);
//        $user = User::create(['name' => 'John Doe']);
//        $item = Item::create(['type' => 'sword', 'user_id' => $user->_id]);
//        $owner = $item->user;
//        $this->assertEquals('John Doe', $owner->name);
//        $book = Book::create(['title' => 'A Clash of Kings']);
//        $this->assertEquals(null, $book->author);
//    }
//    public function testHasOne()
//    {
//        $user = User::create(['name' => 'John Doe']);
//        Role::create(['type' => 'admin', 'user_id' => $user->_id]);
//        $role = $user->role;
//        $this->assertEquals('admin', $role->type);
//        $this->assertEquals($user->_id, $role->user_id);
//        $user = User::create(['name' => 'Jane Doe']);
//        $role = new Role(['type' => 'user']);
//        $user->role()->save($role);
//        $role = $user->role;
//        $this->assertEquals('user', $role->type);
//        $this->assertEquals($user->_id, $role->user_id);
//        $user = User::where('name', 'Jane Doe')->first();
//        $role = $user->role;
//        $this->assertEquals('user', $role->type);
//        $this->assertEquals($user->_id, $role->user_id);
//    }
//    public function testWithBelongsTo()
//    {
//        $user = User::create(['name' => 'John Doe']);
//        Item::create(['type' => 'knife', 'user_id' => $user->_id]);
//        Item::create(['type' => 'shield', 'user_id' => $user->_id]);
//        Item::create(['type' => 'sword', 'user_id' => $user->_id]);
//        Item::create(['type' => 'bag', 'user_id' => null]);
//        $this->assertEquals(3, $user->items->count());
//
////        $items = Item::with('user')->orderBy('user_id', 'desc')->get();
////
////        $user = $items[0]->getRelation('user');
////        $this->assertInstanceOf('User', $user);
////        $this->assertEquals('John Doe', $user->name);
////        $this->assertEquals(1, count($items[0]->getRelations()));
////        $this->assertEquals(null, $items[3]->getRelation('user'));
//    }
//    public function testWithHashMany()
//    {
//        $user = User::create(['name' => 'John Doe']);
//        Item::create(['type' => 'knife', 'user_id' => $user->_id]);
//        Item::create(['type' => 'shield', 'user_id' => $user->_id]);
//        Item::create(['type' => 'sword', 'user_id' => $user->_id]);
//        Item::create(['type' => 'bag', 'user_id' => null]);
//        $user = User::with('items')->find($user->_id);
//        $items = $user->getRelation('items');
//        $this->assertEquals(3, count($items));
//        $this->assertInstanceOf('Item', $items[0]);
//    }
//    public function testWithHasOne()
//    {
//        $user = User::create(['name' => 'John Doe']);
//        Role::create(['type' => 'admin', 'user_id' => $user->_id]);
//        Role::create(['type' => 'guest', 'user_id' => $user->_id]);
//        $user = User::with('role')->find($user->_id);
//        $role = $user->getRelation('role');
//        $this->assertInstanceOf('Role', $role);
//        $this->assertEquals('admin', $role->type);
//    }
//    public function testEasyRelation()
//    {
//        // Has Many
//        $user = User::create(['name' => 'John Doe']);
//        $item = Item::create(['type' => 'knife']);
//        $user->items()->save($item);
//        $user = User::find($user->_id);
//        $items = $user->items;
//        $this->assertEquals(1, count($items));
//        $this->assertInstanceOf('Item', $items[0]);
//        $this->assertEquals($user->_id, $items[0]->user_id);
//        // Has one
//        $user = User::create(['name' => 'John Doe']);
//        $role = Role::create(['type' => 'admin']);
//        $user->role()->save($role);
//        $user = User::find($user->_id);
//        $role = $user->role;
//        $this->assertInstanceOf('Role', $role);
//        $this->assertEquals('admin', $role->type);
//        $this->assertEquals($user->_id, $role->user_id);
//    }
//    public function testBelongsToMany()
//    {
//        $user = User::create(['name' => 'John Doe']);
//        // Add 2 clients
//        $user->clients()->save(new Client(['name' => 'Pork Pies Ltd.']));
//        $user->clients()->create(['name' => 'Buffet Bar Inc.']);
//        // Refetch
//        $user = User::with('clients')->find($user->_id);
//        $client = Client::with('users')->first();
//        // Check for relation attributes
//        $this->assertTrue(array_key_exists('user_ids', $client->getAttributes()));
//        $this->assertTrue(array_key_exists('client_ids', $user->getAttributes()));
//        $clients = $user->getRelation('clients');
//        $users = $client->getRelation('users');
//        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $users);
//        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $clients);
//        $this->assertInstanceOf('Client', $clients[0]);
//        $this->assertInstanceOf('User', $users[0]);
//        $this->assertCount(2, $user->clients);
//        $this->assertCount(1, $client->users);
//        // Now create a new user to an existing client
//        $user = $client->users()->create(['name' => 'Jane Doe']);
//        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->clients);
//        $this->assertInstanceOf('Client', $user->clients->first());
//        $this->assertCount(1, $user->clients);
//        // Get user and unattached client
//        $user = User::where('name', '=', 'Jane Doe')->first();
//        $client = Client::Where('name', '=', 'Buffet Bar Inc.')->first();
//        // Check the models are what they should be
//        $this->assertInstanceOf('Client', $client);
//        $this->assertInstanceOf('User', $user);
//        // Assert they are not attached
//        $this->assertFalse(in_array($client->_id, $user->client_ids));
//        $this->assertFalse(in_array($user->_id, $client->user_ids));
//        $this->assertCount(1, $user->clients);
//        $this->assertCount(1, $client->users);
//        // Attach the client to the user
//        $user->clients()->attach($client);
//        // Get the new user model
//        $user = User::where('name', '=', 'Jane Doe')->first();
//        $client = Client::Where('name', '=', 'Buffet Bar Inc.')->first();
//        // Assert they are attached
//        $this->assertTrue(in_array($client->_id, $user->client_ids));
//        $this->assertTrue(in_array($user->_id, $client->user_ids));
//        $this->assertCount(2, $user->clients);
//        $this->assertCount(2, $client->users);
//        // Detach clients from user
//        $user->clients()->sync([]);
//        // Get the new user model
//        $user = User::where('name', '=', 'Jane Doe')->first();
//        $client = Client::Where('name', '=', 'Buffet Bar Inc.')->first();
//        // Assert they are not attached
//        $this->assertFalse(in_array($client->_id, $user->client_ids));
//        $this->assertFalse(in_array($user->_id, $client->user_ids));
//        $this->assertCount(0, $user->clients);
//        $this->assertCount(1, $client->users);
//    }
//
//}