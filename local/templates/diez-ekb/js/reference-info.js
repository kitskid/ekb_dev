// Скрипт для обработки кнопки "Показать больше"
document.addEventListener('DOMContentLoaded', function() {
    var loadMoreBtn = document.querySelector('.load-more-btn');

    if (loadMoreBtn) {
        // Проверяем есть ли кнопка пагинации "Вперед"
        var nextPageBtn = document.querySelector('.reference-pagination .modern-page-next');

        // Если нет кнопки "Вперед", скрываем кнопку "Показать больше"
        if (!nextPageBtn) {
            loadMoreBtn.style.display = 'none';
            return;
        }

        loadMoreBtn.addEventListener('click', function() {
            var nextPageUrl = nextPageBtn.href;

            // Показываем индикатор загрузки
            loadMoreBtn.disabled = true;
            loadMoreBtn.innerText = 'Загружаем...';

            fetch(nextPageUrl)
                .then(function(response) {
                    return response.text();
                })
                .then(function(html) {
                    // Создаем временный элемент для парсинга HTML
                    var parser = new DOMParser();
                    var doc = parser.parseFromString(html, 'text/html');

                    // Находим новые карточки
                    var newItems = doc.querySelectorAll('.reference-card');
                    var container = document.querySelector('.reference-grid');

                    // Добавляем новые карточки на страницу
                    newItems.forEach(function(item) {
                        container.appendChild(item.cloneNode(true));
                    });

                    // Обновляем пагинацию
                    var newPagination = doc.querySelector('.reference-pagination');
                    var oldPagination = document.querySelector('.reference-pagination');

                    if (newPagination && oldPagination) {
                        oldPagination.innerHTML = newPagination.innerHTML;
                    }

                    // Проверяем, есть ли ещё страницы
                    var newNextPageBtn = document.querySelector('.reference-pagination .modern-page-next');

                    if (!newNextPageBtn) {
                        loadMoreBtn.style.display = 'none';
                    } else {
                        loadMoreBtn.disabled = false;
                        loadMoreBtn.innerText = 'ПОКАЗАТЬ БОЛЬШЕ';
                    }
                })
                .catch(function(error) {
                    console.error('Ошибка загрузки данных:', error);
                    loadMoreBtn.disabled = false;
                    loadMoreBtn.innerText = 'ПОКАЗАТЬ БОЛЬШЕ';
                });
        });
    }
});