<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- Linking Google Fonts for icons -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0"/>
    <link rel="stylesheet" href="./assets/css/main.css">
</head>
<body>
<div class="container">
    <aside class="sidebar">
        <!-- Sidebar header -->
        <header class="sidebar-header">
            <img src="./assets/img/icons/logo.png" alt="company" class="header-logo">
            <!--                    <button class="sidebar-toggle">-->
            <!--                        <span class="material-symbols-rounded">chevron_left</span>-->
            <!--                    </button>-->
        </header>

        <div class="sidebar-content">
            <!--                    <form action="" class="search-form">-->
            <!--                        <span class="material-symbols-rounded">search</span>-->
            <!--                        <input type="search" placeholder="Search..." required>-->
            <!--                    </form>-->

            <ul class="menu-list">
                <li class="menu-item">
                    <a onclick="showPage('visitors_page'); setActiveLink('visitors_link');" class="menu-link active"
                       id="visitors_link">
                        <span class="material-symbols-rounded">group</span>
                        <span class="menu-label">Посетители</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a onclick="showPage('handbooks_page'); setActiveLink('handbooks_link');" class="menu-link"
                       id="handbooks_link">
                        <span class="material-symbols-rounded">assignment</span>
                        <span class="menu-label">Справочники</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a onclick="showPage('dashboard_page'); setActiveLink('dashboard_link');" class="menu-link">
                        <span class="material-symbols-rounded">dashboard</span>
                        <span class="menu-label">Дашборд</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="sidebar-footer">
            <button class="logout-btn">
                <div class="logout-label">
                    <span class="logout-text">Пользователь</span>
                    <span class="material-symbols-rounded">logout</span>
                </div>
            </button>
        </div>

    </aside>
    <section class="section" id="visitors_page">
        <header class="section-header">
            <h1 class="section-title">Список посетителей</h1>
            <a onclick="showPage('add_visitor_page');" class="button">
                <span class="material-symbols-rounded">person_add</span>
                Добавить
            </a>
        </header>
        <?php
        require_once './config/connect.php';

        $sql = "SELECT v.id, v.entry_time, v.exit_time, v.full_name, v.birth_date, v.post, v.department, v.phone, v.remark, d.doc_name 
        FROM visitors v 
        LEFT JOIN documents d ON v.id = d.visitor_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <?php if (!empty($data)): ?>
            <table class="table">
                <thead>
                <tr>
                    <th>№</th>
                    <th>Дата и время входа</th>
                    <th>Дата и время выхода</th>
                    <th>ФИО</th>
                    <th>Дата рождения</th>
                    <th>Должность</th>
                    <th>Отдел</th>
                    <th>Телефон</th>
                    <th>Документ</th>
                    <th>Замечание</th>
                    <th>Действие</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data as $index => $visitor): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= (new DateTime($visitor['entry_time']))->format('d.m.Y H:i') ?></td>
                        <td><?= (new DateTime($visitor['exit_time']))->format('d.m.Y H:i') ?></td>
                        <td><?= $visitor['full_name'] ?></td>
                        <td><?= (new DateTime($visitor['birth_date']))->format('d.m.Y') ?></td>
                        <td><?= $visitor['post'] ?></td>
                        <td><?= $visitor['department'] ?></td>
                        <td><?= $visitor['phone'] ?></td>
                        <td><?= $visitor['doc_name'] ?></td>
                        <td><?= $visitor['remark'] ?></td>
                        <td>
                            <button><span class="material-symbols-rounded">edit</span></button>
                            <button><span class="material-symbols-rounded">delete</span></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align: center; padding-top: 20px;">Нет добавленных посетителей 😕</p>
        <?php endif; ?>
    </section>

    <section class="section" id="add_visitor_page" style="display: none">
        <header class="section-header">
            <h1 class="section-title">Добавить посетителя</h1>
        </header>

        <form class="form" method="POST" action="crud/create_visitor.php">
            <div class="form-group">
                <label class="form-field" for="full_name">
                    ФИО*
                    <input class="input" type="text" name="full_name" id="full_name" maxlength="150" required>
                </label>

                <label class="form-field" for="department">
                    Отдел*
                    <select class="input" name="department" id="department" required>
                        <option value="" selected>Не выбрано</option>
                        <option value="Коммерческий отдел">Коммерческий отдел</option>
                        <option value="Монтажный отдел">Монтажный отдел</option>
                        <option value="Руководящий состав">Руководящий состав</option>
                    </select>
                </label>
            </div>

            <div class="form-group">
                <label class="form-field" for="birth_date">
                    Дата рождения*
                    <input class="input" type="date" name="birth_date" id="birth_date" required>
                </label>

                <label class="form-field" for="post">
                    Должность*
                    <input class="input" type="text" name="post" id="post" maxlength="150" required>
                </label>
            </div>

            <label class="form-field" for="phone">
                Номер телефона*
                <input class="input" type="tel" name="phone" id="phone"
                       pattern="\+7\(\d{3}\)\d{3}-\d{2}-\d{2}"
                       placeholder="+7(000)000-00-00" required>
            </label>

            <p>Документ, удостоверяющий личность*</p>
            <div class="form-group">
                <label>
                    <input onclick="showFields('passport_fields')" type="radio" name="doc_type" value="passport" required>
                    Паспорт
                </label>
                <label>
                    <input onclick="showFields('license_fields')" type="radio" name="doc_type" value="license">
                    Водительское удостоверение
                </label>
                <label>
                    <input onclick="showFields('other_fields')" type="radio" name="doc_type" value="other">
                    Прочее
                </label>
            </div>

            <!-- Паспорт -->
            <div class="doc-fields" id="passport_fields" style="display: none;">
                <div class="form-group">
                    <label class="form-field" for="passport_series">
                        Серия*
                        <input class="input" type="number" name="passport_series" id="passport_series">
                    </label>
                    <label class="form-field" for="passport_number">
                        Номер*
                        <input class="input" type="number" name="passport_number" id="passport_number">
                    </label>
                </div>
                <div class="form-group">
                    <label class="form-field" for="passport_issue_date">
                        Дата выдачи*
                        <input class="input" type="date" name="passport_issue_date" id="passport_issue_date">
                    </label>
                    <label class="form-field" for="passport_issued_by">
                        Кем выдан*
                        <input class="input" type="text" name="passport_issued_by" id="passport_issued_by"
                               maxlength="250">
                    </label>
                </div>
                <label class="form-field" for="unit_code">
                    Код подразделения*
                    <input class="input" type="text" name="unit_code" id="unit_code" pattern="\d{3}-\d{3}"
                           placeholder="000-000">
                </label>
            </div>

            <!-- Водительское удостоверение -->
            <div class="doc-fields" id="license_fields" style="display: none;">
                <div class="form-group">
                    <label class="form-field" for="license_series_number">
                        Серия и номер*
                        <input class="input" type="number" name="license_number" id="license_series_number">
                    </label>
                    <label class="form-field" for="license_issue_date">
                        Дата выдачи*
                        <input class="input" type="date" name="license_issue_date" id="license_issue_date">
                    </label>
                </div>
                <div class="form-group">
                    <label class="form-field" for="license_region">
                        Регион*
                        <input class="input" type="text" name="region" maxlength="150" id="license_region">
                    </label>
                    <label class="form-field" for="license_issued_by">
                        Кем выдан*
                        <input class="input" type="text" name="license_issued_by" id="license_issued_by"
                               maxlength="250">
                    </label>
                </div>
            </div>

            <!-- Прочее -->
            <div class="doc-fields" id="other_fields" style="display: none;">
                <div class="form-group">
                    <label class="form-field" for="other_doc_name">
                        Название документа*
                        <input class="input" type="text" name="other_name" id="other_doc_name" maxlength="150">
                    </label>
                    <label class="form-field" for="other_series_number">
                        Серия и номер*
                        <input class="input" type="number" name="other_number" id="other_series_number">
                    </label>
                </div>
                <div class="form-group">
                    <label class="form-field" for="other_issue_date">
                        Дата выдачи*
                        <input class="input" type="date" name="other_issue_date" id="other_issue_date">
                    </label>
                    <label class="form-field" for="other_issued_by">
                        Кем выдан*
                        <input class="input" type="text" name="other_issued_by" id="other_issued_by" maxlength="250">
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label class="form-field" for="entry_time">
                    Дата и время входа*
                    <input class="input" type="datetime-local" name="entry_time" id="entry_time" required>
                </label>

                <label class="form-field" for="exit_time">
                    Дата и время выхода*
                    <input class="input" type="datetime-local" name="exit_time" id="exit_time" required>
                </label>
            </div>

            <label class="form-field" for="remark">
                Замечание
                <textarea class="textarea" name="remark" id="remark"></textarea>
            </label>

            <div class="btn-group">
                <button class="button" type="submit">Добавить</button>
                <a onclick="showPage('visitors_page'); setActiveLink('visitors_link');"
                   class="button-secondary">Отмена</a>
                <p><small>* – обязательные поля</small></p>
            </div>
        </form>
    </section>

    <section class="section" id="handbooks_page" style="display: none">
        <header class="section-header">
            <h1 class="section-title">Страница справочники</h1>
        </header>
    </section>

    <section class="section" id="dashboard_page" style="display: none">
        <header class="section-header">
            <h1 class="section-title">Страница с дашбордом</h1>
        </header>
    </section>
</div>

<script src="assets/js/script.js"></script>
</body>
</html>