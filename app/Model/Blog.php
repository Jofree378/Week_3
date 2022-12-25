<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    // Модель сообщения

    public $timestamps = false;
    public $table = 'posts';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'message',
        'send_at',
        'image',
    ];

    // Создание отношения
    public function userdata()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Получение последних n сообщений
    public static function getPosts(int $limit)
    {
        return self::with('userdata')->orderBy('id', 'desc')
            ->limit($limit)->get()->toArray();
    }

//    // Выод сообщений конкретного пользователя через api
//    public static function getUserPosts(int $userId, int $limit): ?array
//    {
//        $db = Db::getInstance();
//        $select = "SELECT * FROM posts WHERE user_id = $userId LIMIT $limit";
//        $dataPost = $db->fetchAll($select);
//        if (!$dataPost) {
//            return null;
//        }
//
//        $messages = [];
//        foreach ($dataPost as $elem) {
//            $posts = new self($elem);
//            $posts->postId = $elem['post_id'];
//            $posts->userId = $elem['user_id'];
//            $posts->datetime = $elem['datetime'];
//            $posts->message= $elem['message'];
//            $messages[] = $posts;
//        }
//
//        return $messages;
//    }

    // Функция удаленмия сообщения пользователя
    public static function deleteByPostId($postId)
    {
        return self::destroy($postId);
    }

//    // Получение данных для api метода
//    public function getData()
//    {
//        return ['post_id' => $this->postId,
//            'user_id' => $this->userId,
//            'datetime' => $this->datetime,
//            'message' => $this->message];
//    }
}