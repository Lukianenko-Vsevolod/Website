import React, { useState } from 'react';

function ProfileCard() {
  const [avatarUrl, setAvatarUrl] = useState(null);

  const handleImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
      const imageUrl = URL.createObjectURL(file);
      setAvatarUrl(imageUrl);
    }
  };

  return (
    <div>
      <h1>Моя визитка</h1>
      <div>
        {avatarUrl ? (
          <img src={avatarUrl} alt="avatar" width="100" />
        ) : (
          <div>Нет фото</div>
        )}
      </div>
      <input type="file" accept="image/*" onChange={handleImageUpload} />
      <p>Имя: Лукьяненко Всеволод Алексеевич</p>
      <p>Специальность: Информатика и вычислительная техника</p>
      <p>Группа: БИВТ-24-2</p>
      <p>О себе: Студент, 2 курса</p>
    </div>
  );
}

export default ProfileCard;
