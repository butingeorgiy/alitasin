<?php

return [
    // General messages
    'tour-not-found' => 'Tur bulunamadı!',
    'manager-not-found' => 'Yönetici bulunamadı!',
    'region-not-found' => 'Bölge bulunamadı!',
    'tour-type-not-found' => 'Tur türü bulunamadı!',
    'updating-failed' => 'Güncellemeler kaydedilemedi!',
    'updating-success' => 'Güncellemeler başarıyla kaydedildi!',
    'tour-created' => 'Tur başarıyla kaydedildi!',
    'tour-creation-failed' => 'Gezi oluşturulamadı!',
    'specify-image-id' => 'Görüntü kimliğini girin!',
    'image-not-found' => 'Resim bulunamadı!',
    'image-not-attached-to-tour' => 'Görüntü belirtilen geziye eklenmemiş!',
    'tour-image-already-main' => 'Görüntü zaten ana görüntü!',
    'cannot-delete-main-image' => 'Ana tur görüntüsü silinemiyor!',
    'tour-image-deleting-success' => 'Resim başarıyla silindi!',
    'tour-can-have-max-five-images' => 'Tura 5\'ten fazla resim eklenemez!',
    'max-uploaded-file-size' => 'Dosya boyutu 2 MB\'ı geçemez!',
    'allowed-file-extensions' => 'Yalnızca JPG, JPEG ve PNG resim formatları desteklenir!',
    'tour-must-have-image' => 'Tura en az bir resim eklemeniz gerekiyor!',
    'file-uploading-success' => 'Dosya başarıyla kaydedildi!',
    'user-not-found' => 'Kullanıcı bulunamadı!',
    'email-required' => 'E-posta belirtmeniz gerekir',
    'password-required' => 'Şifre gereklidir!',
    'min-password-length' => 'Minimum şifre uzunluğu 8 karakter!',
    'email-wrong-format' => 'Geçersiz e-posta biçimi!',
    'wrong-credentials' => 'Şifre yanlış!',
    'no-results' => 'Sonuç bulunamadı!',
    'tour-filters-parse-error' => 'Gezileri aramak için yanlış filtre formatı!',
    'tour-types-parse-error' => 'Gezileri aramak için yanlış tür biçimi!',

    // Tour validation messages
    'tour-en-title-required' => 'Turun adını İngilizce olarak belirtmeniz gerekir!',
    'tour-en-title-min' => 'İngilizce turun adı 10 karakterden kısa olmamalıdır!',
    'tour-en-title-max' => 'İngilizce turun adı 256 karakterden uzun olmamalıdır!',
    'tour-ru-title-required' => 'Turun adını Rusça olarak belirttiğinizden emin olun!',
    'tour-ru-title-min' => 'Rusça\'daki turun adı 10 karakterden daha kısa olmamalıdır!',
    'tour-ru-title-max' => 'Rusça\'daki turun adı 256 karakterden uzun olmamalıdır!',
    'tour-tr-title-required' => 'Turun adını Türkçe olarak belirtmeniz gerekir!',
    'tour-tr-title-min' => 'Turun Türkçe adı 10 karakterden kısa olmamalıdır!',
    'tour-tr-title-max' => 'Turun Türkçe adı 256 karakterden uzun olmamalıdır!',
    'tour-en-description-required' => 'Turun açıklamasını İngilizce olarak belirttiğinizden emin olun!',
    'tour-en-description-min' => 'İngilizce tur açıklaması 10 karakterden daha kısa olmamalıdır!',
    'tour-en-description-max' => 'İngilizce tur açıklaması 2048 karakterden uzun olmamalıdır!',
    'tour-ru-description-required' => 'Turun açıklamasını Rusça olarak belirttiğinizden emin olun!',
    'tour-ru-description-min' => 'Rusça tur açıklaması 10 karakterden daha kısa olmamalıdır!',
    'tour-ru-description-max' => 'Rusça tur açıklaması 2048 karakterden daha uzun olmamalıdır!',
    'tour-tr-description-required' => 'Turun açıklamasını Türkçe olarak belirttiğinizden emin olun!',
    'tour-tr-description-min' => 'Türkçe tur açıklaması 10 karakterden kısa olmamalıdır!',
    'tour-tr-description-max' => 'Türkçe tur açıklaması 2048 karakterden uzun olmamalıdır!',
    'tour-address-required' => 'Turun adresini belirtmeniz gerekir!',
    'tour-address-min' => 'Adres 10 karakterden kısa olmamalıdır!',
    'tour-address-max' => 'Adres 256 karakterden uzun olmamalıdır!',
    'tour-manager-require' => 'Tur Yöneticisini belirtmeniz gerekir!',
    'tour-manager-id-numeric' => 'Geçersiz yönetici kimliği! Kimlik bir sayıdır!',
    'tour-region-require' => 'Turun bölgesini belirtmeniz gerekir!',
    'tour-region-id-numeric' => 'Geçersiz bölge kimliği! Kimlik bir sayıdır!',
    'tour-price-require' => 'Turun fiyatını belirtmeniz gerekir!',
    'tour-price-numeric' => 'Turun fiyatı bir sayı olmalıdır!',
    'tour-price-min' => 'Fiyat negatif olamaz!',
    'tour-conducted-at-require' => 'Gezinin günlerini belirtmelidir!',
    'tour-conducted-at-json' => 'Yanlış hafta günleri! JSON gönderilmelidir!',
    'tour-conducted-at-min' => 'En az bir yürütülen gün belirtmelidir!',
    'tour-type-require' => 'Tur türünü belirtmeniz gerekir!',
    'tour-type-id-numeric' => 'Geçersiz turun tip kimliği! Kimlik bir sayıdır!',
    'tour-filters-require' => 'Turun filtrelerini belirtmeniz gerekir!',
    'tour-filters-json' => 'Geçersiz filtre biçimi! JSON gönderilmelidir!',
    'tour-filters-min' => 'En az bir filtre belirtmeniz gerekir!',
    'tour-duration-format' => 'Geçersiz süre biçimi!',
    'week-day-invalid' => 'Geçersiz gün!'
];
