<?php

return [
    // Tour validation messages
    'tour-en-title-required' => 'Необходимо указать название экскурсии на английском языке!',
    'tour-en-title-min' => 'Название экскурсии на английском языке не должно быть короче 10 символов!',
    'tour-en-title-max' => 'Название экскурсии на английском языке не должно быть длиннее 256 символов!',
    'tour-ru-title-required' => 'Необходимо указать название экскурсии на русском языке!',
    'tour-ru-title-min' => 'Название экскурсии на русском языке не должно быть короче 10 символов!',
    'tour-ru-title-max' => 'Название экскурсии на русском языке не должно быть длиннее 256 символов!',
    'tour-tr-title-required' => 'Необходимо указать название экскурсии на турецком языке!',
    'tour-tr-title-min' => 'Название экскурсии на турецком языке не должно быть короче 10 символов!',
    'tour-tr-title-max' => 'Название экскурсии на турецком языке не должно быть длиннее 256 символов!',
    'tour-en-description-required' => 'Необходимо указать описание экскурсии на английском языке!',
    'tour-en-description-min' => 'Описание экскурсии на английском языке не должно быть короче 10 символов!',
    'tour-en-description-max' => 'Описание экскурсии на английском языке не должно быть длиннее 2048 символов!',
    'tour-ru-description-required' => 'Необходимо указать описание экскурсии на русском языке!',
    'tour-ru-description-min' => 'Описание экскурсии на русском языке не должно быть короче 10 символов!',
    'tour-ru-description-max' => 'Описание экскурсии на русском языке не должно быть длиннее 2048 символов!',
    'tour-tr-description-required' => 'Необходимо указать описание экскурсии на турецком языке!',
    'tour-tr-description-min' => 'Описание экскурсии на турецком языке не должно быть короче 10 символов!',
    'tour-tr-description-max' => 'Описание экскурсии на турецком языке не должно быть длиннее 2048 символов!',
    'tour-available-time-required' => 'Необходимо указать доступное время экскурсии!!',
    'tour-available-time-json' => 'Некорректное доступное время! Необходимо отправить JSON!',
    'tour-available-time-min' => 'Необходимо указать хотя бы одно доступное время!',
    'tour-manager-require' => 'Необходимо указать менеджера!',
    'tour-manager-id-numeric' => 'Некорректный ID менеджера! ID является числом!',
    'tour-region-require' => 'Необходимо указать регион проведения экскурсии!',
    'tour-region-id-numeric' => 'Некорректный ID региона! ID является числом!',
    'tour-price-require' => 'Укажите стоимость экскурсии!',
    'tour-price-numeric' => 'Стоимость должна быть числом!',
    'tour-price-min' => 'Стоимость не может быть отрицательной!',
    'tour-conducted-at-require' => 'Укажите дни проведения экскурсии!',
    'tour-conducted-at-json' => 'Некорректный тип дней недель! Необходимо отправить JSON!',
    'tour-conducted-at-min' => 'Необходимо указать хотя бы один день недели!',
    'tour-type-require' => 'Укажите тип экскурсии!',
    'tour-type-id-numeric' => 'Некорректный ID типа экскурсии!',
    'tour-filters-require' => 'Укажите фильтры!',
    'tour-filters-json' => 'Некорректный тип фильтров! Необходимо отправить JSON!',
    'tour-filters-min' => 'Необходимо указать хотя бы один фильтр!',
    'tour-duration-format' => 'Некорректный формат продолжительности экскурсии!',
    'tour-filters-parse-error' => 'Некорректный формат фильтров для поиска экскурсий!',
    'tour-types-parse-error' => 'Некорректный формат типов для поиска экскурсий!',
    'tour-additions-json' => 'Некорректный формат дополнений! Необходимо отправить JSON!',

    // User validation messages
    'user-first-name-required' => 'Укажите имя!',
    'user-first-name-min' => 'Минимальная длина имени 2 символа!',
    'user-first-name-max' => 'Максимальная длина имени 32 символа!',
    'user-last-name-min' => 'Минимальная длина фамилии 2 символа!',
    'user-last-name-max' => 'Максимальная длина фамилии 32 символа!',
    'user-email-required' => 'Укажите E-mail!',
    'user-email-email' => 'Некорректный формат E-mail!',
    'user-email-max' => 'Максимальная длина E-mail 128 символа',
    'user-email-unique' => 'Указанный E-mail уже зарегистрирован',
    'user-phone-required' => 'Укажите телефон!',
    'user-phone-regex' => 'Некорректный формат телефона!',
    'user-creating-failed' => 'Не удалось создать пользователя!',

    // Tour reservation validation messages
    'hotel-name-min' => 'Минимальная длина названия отеля 4 символа!',
    'hotel-name-max' => 'Максимальная длина названия отеля 64 символа!',
    'communication_type-min' => 'Минимальная длина способа связи 4 символа!',
    'communication_type-max' => 'Максимальная длина способа связи 32 символа!',
    'time-format' => 'Некорректный формат времени!',
    'date-format' => 'Некорректный формат даты!',
    'promo-code-min' => 'Промо код не может быть пустым!',
    'promo-code-max' => 'Максимальная длина промо кода 32 символа!',
    'tickets-required' => 'Необходимо указать билеты!',
    'tickets-json' => 'Некорректный формат билетов! Необходимо отправить JSON',
    'ticket-not-found' => 'Билет не найден!',
    'tickets-min' => 'Укажите хотя бы один билет!',
    'reservation-creating-failed' => 'Не удалось забронировать экскурсию!',
    'reservation-creating-success' => 'Экскурсия успешно забронирована!',
    'reservation->time-not-available' => 'Указанное время недоступно для бронирования!',
    'reservation->date-not-available' => 'Указанная дата недоступна для бронирования!',

    // General messages
    'tour-not-found' => 'Экскурсия не найдена!',
    'manager-not-found' => 'Менеджер не найден!',
    'region-not-found' => 'Регион не найден!',
    'tour-type-not-found' => 'Тип экскурсии не найден!',
    'updating-failed' => 'Не удалось сохранить изменения!',
    'updating-success' => 'Изменения успешно сохранены!',
    'tour-created' => 'Экскурсия была успешно сохранена!',
    'tour-creation-failed' => 'Не удалось создать экскурсию!',
    'specify-image-id' => 'Укажите ID изображения!',
    'image-not-found' => 'Изображение не найдено!',
    'image-not-attached-to-tour' => 'Изображение не прикреплено указанной экскурсии!',
    'tour-image-already-main' => 'Изображение уже является главным!',
    'cannot-delete-main-image' => 'Нельзя удалить основное изображение экскурсии!',
    'tour-image-deleting-success' => 'Изображение успешно удалено!',
    'tour-can-have-max-five-images' => 'К экскурсии может быть добавлено не ' .
                                        'больше 5-и изображений!',
    'max-uploaded-file-size' => 'Размер файла не может превышать 2 мб!',
    'allowed-file-extensions' => 'Поддерживаются только JPG, JPEG и PNG форматы изображений!',
    'tour-must-have-image' => 'Необходимо прикрепить хотя бы одно изображение к экскурсии!',
    'file-uploading-success' => 'Файл успешно загружен!',
    'user-not-found' => 'Пользователь не найден!',
    'email-required' => 'Укажите E-mail!',
    'password-required' => 'Укажите пароль!',
    'min-password-length' => 'Минимальная длина пароля 8 символов!',
    'email-wrong-format' => 'Некорректный формат E-mail!',
    'wrong-password' => 'Пароль неверный!',
    'no-results' => 'Ничего не найдено!',
    'week-day-invalid' => 'Некорректный день недели!',
    'time-invalid' => 'Некорректный формат времени!',
    'profile-photo-size-max' => 'Максимальный размер изображения 500 KB!',
    'file-required' => 'Необходимо загрузить файл!',
    'promo-code-required' => 'Укажите промо код!',
    'promo-code-not-found' => 'Промо код не найден!',
    'tour-deleting-success' => 'Экскурсия успешно удалена!',
    'tour-deleting-failed' => 'Не удалось удалить экскурсию!',
    'reservation-status-not-found' => 'Указанного статуса не существует!',
    'reservation-not-found' => 'Брони не найдено!',
    'user-not-authorized' => 'Пользователь не авторизован!',
    'sale-percent-required' => 'Укажите процент скидки!',
    'percent-numeric' => 'Процент должен быть числом!',
    'percent-min' => 'Процент не может быть меньше 0!',
    'percent-max' => 'Процент не может быть больше 100!',
    'partner-creating-success' => 'Новый партнёр успешно создан!',
    'partner-ban-failed' => 'Не удалось заблокировать партнёра!',
    'partner-ban-success' => 'Партнёр успешно заблокирован!',
    'partner-restore-failed' => 'Не удалось восстановить партнёра!',
    'partner-restore-success' => 'Партнёр успешно восстановлен!',
    'payment-amount-required' => 'Укажите сумму выплаты!',
    'payment-amount-numeric' => 'Сумма выплаты должна быть числом!',
    'payment-amount-min' => 'Сумма выплаты не может быть меньше 0!',
    'partner-payment-amount-max' => 'Сумма выплаты не может быть больше, чем остаток прибыли партнёра!',
    'partner-payment-saving-success' => 'Выплата успешно сохранена!',
    'hotel-room-number-max' => 'Максимальная длина номера комнаты 8 символов!',
    'profit-percent-required' => 'Укажите процент прибыли!',
    'profit-percent-numeric' => 'Процент прибыли должен быть числом!',
    'profit-percent-min' => 'Процент прибыли не может быть меньше 0!',
    'profit-percent-max' => 'Процент прибыли не может быть больше 100!',
    'sub-partner-profit-percent-required' => 'Укажите процент прибыли от под партнёра!'
];
