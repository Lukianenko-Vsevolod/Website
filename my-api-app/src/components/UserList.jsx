import React, { useState, useEffect } from 'react';

function UserList() {
  const [users, setUsers] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    fetch('https://jsonplaceholder.typicode.com/users')
      .then(function(response) {
        return response.json();
      })
      .then(function(data) {
        console.log('Пользователи загружены:', data);
        setUsers(data);
        setLoading(false);
      })
      .catch(function(err) {
        console.log('Ошибка:', err);
        setError('Ошибка загрузки');
        setLoading(false);
      });
  }, []);

  if (loading) {
    return <p>Загрузка пользователей...</p>;
  }

  if (error) {
    return <p>Ошибка: {error}</p>;
  }

  if (users.length === 0) {
    return <p>Нет данных</p>;
  }

  return (
    <div>
      <h1>Список пользователей</h1>
      <ul>
        {users.map(function(user) {
          return (
            <li key={user.id}>
              <strong>{user.name}</strong> - {user.email}
            </li>
          );
        })}
      </ul>
    </div>
  );
}

export default UserList;
