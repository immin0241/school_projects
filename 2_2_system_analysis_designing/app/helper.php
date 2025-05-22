<?php
    if(!function_exists("print_stars")) {
        function print_stars($count) {
            $stars = str_repeat("⭐", floor($count));
            return $stars."<span style='filter:brightness(10)'>".str_repeat("⭐", 5-floor($count))."</span>";
        }
    }
