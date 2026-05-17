import React, { useState, useEffect } from 'react';

function App() {
  const [users, setUsers] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(false);

  useEffect(() => {
    // Рабочий API от GitHub
    fetch('https://api.github.com/users')
      .then((response) => response.json())
      .then((data) => {
        console.log('Данные загружены:', data);
        setUsers(data.slice(0, 10)); // Берём первых 10 пользователей
        setLoading(false);
      })
      .catch((err) => {
        console.log('Ошибка:', err);
        setError(true);
        setLoading(false);
      });
  }, []);

  if (loading) {
    return <h2>Загрузка данных с GitHub...</h2>;
  }

  if (error) {
    return (
      <div>
        <h2>Ошибка загрузки данных</h2>
        <p>Проверьте подключение к интернету</p>
      </div>
    );
  }

  return (
    <div>
      <h1>Практическая работа №8</h1>
      <h2>Работа с API в React</h2>
      <h3>Пользователи GitHub (всего: {users.length})</h3>
      <ul style={{ textAlign: 'left', fontSize: '18px' }}>
        {users.map((user) => (
          <li key={user.id} style={{ marginBottom: '15px' }}>
            <strong>{user.login}</strong><br />
            <a href={user.html_url} target="_blank">Профиль на GitHub</a>
          </li>
        ))}
      </ul>
    </div>
  );
}

export default App;
