<?php
/**
 * @var $values array
 * @var $totalScore
 * @var $showScore
 * @var $scoreResult
 * @var $errors
 */
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="content-type" content="text/html" />
    <title>Анкета</title>
    <link rel="stylesheet" href="/views/style.css">
</head>

<body>

<div class="main">
    <h3>Анкета</h3>
    <?php if($errors){ ?>
        <div class="error">Ошибка при заполнении формы</div>
    <? } ?>
    <?php if($showScore && !$scoreResult){ ?>
        <div class="error">Отказ в выдаче кредита</div>
    <? } ?>
    <?php if($showScore && $scoreResult){ ?>
        <div class="success">Одобрение в выдаче кредита</div>
    <? } ?>
    <form method="post">
        <div class="row">
            <div>
                <label>Фамилия*</label>
                <input name="family" value="<?= $values['family'] ?>">
            </div>
            <div>
                <label>Имя*</label>
                <input name="name" value="<?= $values['name'] ?>">
            </div>
        </div>
        <div class="row">
            <div>
                <label>Отчество*</label>
                <input name="surname" value="<?= $values['surname'] ?>">
            </div>
            <div>
                <label>Пол*</label>
                <select name="sex">
                    <option value="0">женщина</option>
                    <option value="1" <?= $values['sex'] == 1 ? 'selected' : '' ?>>мужчина</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div>
                <label>Дата рождения*</label>
                <input
                        value="<?= $values['birthday'] ?>"
                        type="date"
                        min="<?= date('Y-m-d', strtotime('-65 year')) ?>"
                        max="<?= date('Y-m-d', strtotime('-14 year')) ?>"
                        name="birthday"
                >
            </div>
            <div>
                <label>Количество несовершеннолетних детей*</label>
                <select name="children">
                    <?php
                    for($i = 0; $i < 31; ++$i) { ?>
                        <option value="<?= $i ?>" <?= $values['children'] == $i ? 'selected' : '' ?> ><?= $i ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div>
                <label>Семейное положение*</label>
                <select name="marital">
                    <option value="0">холост/не замужем</option>
                    <option value="1" <?= $values['marital'] == 1 ? 'selected' : '' ?> >женат/замужем</option>
                </select>
            </div>
            <div>
                <label>Ежемесячный доход*</label>
                <input type="number" value="<?= $values['salary'] ?>" name="salary">
            </div>
        </div>
        <div class="row">
            <div>
                <label>Тип занятости*</label>
                <select name="employment">
                    <option value="0">не работаю</option>
                    <option value="1" <?= $values['employment'] == 1 ? 'selected' : '' ?> >договор</option>
                    <option value="2" <?= $values['employment'] == 2 ? 'selected' : '' ?> >самозанятый</option>
                    <option value="3" <?= $values['employment'] == 3 ? 'selected' : '' ?> >индивидуальный предприниматель</option>
                </select>
            </div>
            <div>
                <label>Есть ли недвижимость*</label>
                <input type="checkbox" <?= $values['real_estate'] ? 'checked' : '' ?> name="real_estate">
            </div>
        </div>
        <div class="row">
            <div>
                <label for="credit">Есть ли непогашенные кредиты*</label>
                <input type="checkbox" id="credit" <?= $values['credit'] ? 'checked' : '' ?> name="credit">
            </div>
            <div>
                <label for="debt">Есть ли задолженности по текущим кредитам*</label>
                <input type="checkbox" disabled id="debt" <?= $values['debt'] ? 'checked' : '' ?> name="debt">
            </div>
        </div>
        <div class="row">
            <div>
                <label for="credit_price">Ежемесячная выплата по текущим кредитам*</label>
                <input type="number" disabled id="credit_price" name="credit_price" value="<?= $values['credit_price'] ?>">
            </div>
            <div></div>
        </div>
        <div style="margin-top: 20px">
            <button type="submit">Отправить</button>
        </div>
    </form>
    score: <?= $totalScore ?>
</div>
<script>
    const $credit = document.getElementById('credit');
    $credit.onclick = () => checkCredit();
    checkCredit();

    function checkCredit() {
        let $debt = document.getElementById('debt');
        let $credit_price = document.getElementById('credit_price');
        if($credit.checked) {
            $debt.disabled = false;
            $credit_price.disabled = false;
        } else {
            $debt.disabled = true;
            $credit_price.disabled = true;
        }
    }
</script>

</body>
</html>