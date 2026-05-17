import React, { useState, useEffect } from 'react';

function PostList() {
  const [posts, setPosts] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    fetch('https://jsonplaceholder.typicode.com/posts')
      .then(function(response) {
        return response.json();
      })
      .then(function(data) {
        console.log('Посты загружены:', data);
        var firstTen = data.slice(0, 10);
        setPosts(firstTen);
        setLoading(false);
      })
      .catch(function(err) {
        console.log('Ошибка:', err);
        setError('Ошибка загрузки');
        setLoading(false);
      });
  }, []);

  if (loading) {
    return <p>Загрузка постов...</p>;
  }

  if (error) {
    return <p>Ошибка: {error}</p>;
  }

  if (posts.length === 0) {
    return <p>Нет данных</p>;
  }

  return (
    <div>
      <h1>Список постов</h1>
      <ul>
        {posts.map(function(post) {
          return (
            <li key={post.id}>
              <strong>{post.title}</strong>
              <p>{post.body}</p>
            </li>
          );
        })}
      </ul>
    </div>
  );
}

export default PostList;
