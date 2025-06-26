document.addEventListener('DOMContentLoaded', function() {
    var loadMoreBtn = document.querySelector('.load-more-btn');

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            var btn = this;
            var container = document.getElementById('attractions-container');
            var rowContainer = container.querySelector('.row');
            var currentPage = parseInt(btn.dataset.page);
            var totalPages = parseInt(btn.dataset.totalPages);
            var path = btn.dataset.path;
            var params = btn.dataset.params;

            // Показываем индикатор загрузки
            btn.disabled = true;
            btn.innerHTML = 'Загрузка...';

            // Отправляем AJAX-запрос
            var xhr = new XMLHttpRequest();
            xhr.open('POST', path, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        var response = JSON.parse(xhr.responseText);

                        if (response.success) {
                            // Добавляем новые элементы в контейнер
                            if (response.items && response.items.length) {
                                response.items.forEach(function(item) {
                                    rowContainer.innerHTML += item;
                                });

                                // Обновляем данные кнопки
                                btn.dataset.page = currentPage + 1;

                                // Добавляем новые точки на карту
                                if (typeof addPointsToMap === 'function' && response.mapData) {
                                    addPointsToMap(response.mapData);
                                }
                            }

                            // Скрываем кнопку, если больше нет страниц
                            if (!response.hasMore) {
                                btn.parentNode.removeChild(btn);
                            }
                        } else {
                            console.error('Error loading more items:', response.message);
                        }
                    } catch (e) {
                        console.error('Error parsing JSON response:', e);
                    }
                } else {
                    console.error('Request failed. Status:', xhr.status);
                }

                // Восстанавливаем кнопку
                btn.disabled = false;
                btn.innerHTML = 'Показать больше достопримечательностей';
            };

            xhr.onerror = function() {
                console.error('Request failed');
                btn.disabled = false;
                btn.innerHTML = 'Показать больше достопримечательностей';
            };

            xhr.send('params=' + encodeURIComponent(params) + '&page=' + currentPage + '&totalPages=' + totalPages);
        });
    }
});
