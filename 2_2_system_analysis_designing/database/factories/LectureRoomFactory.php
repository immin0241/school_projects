<?php

namespace Database\Factories;

use App\Models\LectureRoom;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LectureRoom>
 */
class LectureRoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'professor_id' => 1,
            'title',
            'description' => fake()->realText(200),
        ];
    }

    public function createPredefinedLectureRooms() {
        $titles = ["차별화된 취업전략! 독하게 시작하는 Java - Part 1","비전공자도 이해할 수 있는 DB 설계 입문_실전","김영한의 실전 자바 - 고급 2편, I_O, 네트워크, 리플렉션","피그마 배리어블을 활용한 디자인 시스템 구축하기","파이썬입문과 크롤링기초 부트캠프 [파이썬, 웹, 데이터 이해 기본까지] (업데이트)","퍼블리셔 취업 진짜 실전 가이드(PDF)","[백문이불여일타] 데이터 분석을 위한 기초 SQL","HTML+CSS+JS 포트폴리오 실전 퍼블리싱(시즌1)","시니어 면접관이 알려주는 개발자 취업과 이직 한방에 해결하기 [이론편]","[게임 프로그래머 입문 올인원] C++ & 자료구조_알고리즘 & STL & 게임 수학 & Windows API & 게임 서버","[2024 리뉴얼] 처음하는 SQL과 데이터베이스(MySQL) 부트캠프 [입문부터 활용까지]","이해하면 인생이 바뀌는 Windows API hook","외워서 끝내는 네트워크 핵심이론 - 기초","TailwindCSS 완전 정복: 포트폴리오부터 어드민까지!","제대로 파는 HTML CSS - by 얄코","넓고 얕게 외워서 컴공 전공자 되기","[C#과 유니티로 만드는 MMORPG 게임 개발 시리즈] Part1: C# 기초 프로그래밍 입문","비전공자도 이해할 수 있는 Docker 입문_실전","[2024년 출제기준] 웹디자인기능사 실기시험 완벽 가이드(HTML+CSS+JQUERY)","비전공자도 이해할 수 있는 MySQL 성능 최적화 입문_실전 (SQL 튜닝편)","카카오 코테 6주 합격! 실전 파이썬 코딩테스트","MFC Windows 프로그래밍 - 응용","곰책으로 쉽게 배우는 최소한의 운영체제론","[2024 최신] [코드팩토리] [초급] Flutter 3.0 앱 개발 - 10개의 프로젝트로 오늘 초보 탈출!","10주완성 C++ 코딩테스트 | 알고리즘 코딩테스트","외워서 끝내는 네트워크 핵심이론 - 응용","비전공자도 이해할 수 있는 AWS 입문_실전","이해하면 인생이 바뀌는 네트워크 프로그래밍","홍정모의 따라하며 배우는 C++","퍼블리싱 핵심이론 PDF 교재 및 예제파일(HTML+CSS+FLEX+JQUERY)","비전공자를 위한 진짜 입문 올인원 개발 부트캠프","디자인 시스템 with 피그마","Verilog FPGA Program 1 (HIL-A35T)","[왕초보편] 앱 8개를 만들면서 배우는 안드로이드 코틀린(Android Kotlin)","모바일 웹 퍼블리싱 포트폴리오 with Figma","[백문이불여일타] 데이터 분석을 위한 중급 SQL","(2025) 일주일만에 합격하는 정보처리기사 실기","CPPG 개인정보관리사 자격증 취득하기 (개정안 반영)","[개정3판] Node.js 교과서 - 기본부터 프로젝트 실습까지","[2024] 한입 크기로 잘라 먹는 리액트(React.js) : 기초부터 실전까지","2주만에 통과하는 알고리즘 코딩테스트 (2024년)","테스트 with Jest: 제로초에게 제대로 배우기","개발자를 위한 쉬운 도커","스프링 핵심 원리 - 기본편","순수 html_css_js만을 활용한 반응형웹 제작[실전편] 부트캠프","Tailwind CSS로 만드는 멋진 웹 UI 스타일링","스프링 프레임워크는 내 손에 [스프1탄]","제대로 파는 Git & GitHub - by 얄코","맛집 지도앱 만들기 (React Native + NestJS)","풀스택을 위한 탄탄한 프런트엔드 부트캠프 (HTML, CSS, 바닐라 자바스크립트 + ES6) [풀스택 Part2]","8시간 완성 SQLD(2과목)","처음하는 플러터(Flutter) 기초부터 실전까지 [풀스택 Part4] (쉽고 견고하게 단계별로 다양한 프로젝트까지)","Git & GitHub, 원리부터 차근차근 - 근본깃 [무료]","파이썬으로 나만의 블로그 자동화 프로그램 만들기","Readable Code: 읽기 좋은 코드를 작성하는 사고법","쉽고 재미있게 배우는 [CSS3 스타일부터 인터렉티브 웹제작까지] 부트캠프","왕초보를 위한 네트워크 기초","시작해보세요! 당신의 첫 지식공유","Verilog FPGA Program 3 (DDR Controller, HIL-A35T)"];

        foreach ($titles as $title) {
            try {
                $path = Storage::putFile('lecture_thumbnails', 'C:\\Users\\immin\\Herd\\sibunseol\\database\\factories\\images\\'.$title.".png", 'public');
            } catch (FileNotFoundException) {
                continue;
            }

            LectureRoom::create([
                'professor_id' => 1,
                'title' => $title,
                'description' => fake()->realText(200),
                'thumbnail' => $path
            ]);
        }
    }
}
