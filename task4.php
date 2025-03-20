<?php
function crop_text($text, $word_limit = 29) {
    $word_count = 0;
    $result = '';

    preg_match_all('/(<[^>]*>)|([^<]+)/', $text, $matches);


    foreach ($matches[0] as $part) {
        if (strip_tags($part) === $part) {
            $clean_text = str_replace(['.', '-'], '', $part);
            $words = preg_split('/\s+/u', trim($clean_text), -1, PREG_SPLIT_NO_EMPTY);
            $remaining_words = $word_limit - $word_count;

            if (count($words) <= $remaining_words) {
                $result .= $part;
                $word_count += count($words);

            } else {
                $result .= implode(' ', array_slice($words, 0, $remaining_words)) . '...';
                break;
            }
        } else {
            $result .= $part;
        }
    }

    return $result;
}

$text = <<<TXT
<p class="big">
	Год основания:<b>1589 г.</b> Волгоград отмечает день города в <b>2-е воскресенье сентября</b>. <br>В <b>2023 году</b> эта дата - <b>10 сентября</b>.
</p>
<p class="float">
	<img src="https://www.calend.ru/img/content_events/i0/961.jpg" alt="Волгоград" width="300" height="200" itemprop="image">
	<span class="caption gray">Скульптура «Родина-мать зовет!» входит в число семи чудес России (Фото: Art Konovalov, по лицензии shutterstock.com)</span>
</p>
<p>
	<i><b>Великая Отечественная война в истории города</b></i></p><p><i>Важнейшей операцией Советской Армии в Великой Отечественной войне стала <a href="https://www.calend.ru/holidays/0/0/1869/">Сталинградская битва</a> (17.07.1942 - 02.02.1943). Целью боевых действий советских войск являлись оборона  Сталинграда и разгром действовавшей на сталинградском направлении группировки противника. Победа советских войск в Сталинградской битве имела решающее значение для победы Советского Союза в Великой Отечественной войне.</i>
</p>
TXT;

echo crop_text($text);
