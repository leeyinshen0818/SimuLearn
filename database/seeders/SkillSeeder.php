<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            // Frontend
            ['name' => 'HTML', 'category' => 'Frontend'],
            ['name' => 'CSS', 'category' => 'Frontend'],
            ['name' => 'JavaScript', 'category' => 'Frontend'],
            ['name' => 'TypeScript', 'category' => 'Frontend'],
            ['name' => 'React', 'category' => 'Frontend'],
            ['name' => 'Vue.js', 'category' => 'Frontend'],
            ['name' => 'Angular', 'category' => 'Frontend'],
            ['name' => 'Svelte', 'category' => 'Frontend'],
            ['name' => 'Next.js', 'category' => 'Frontend'],
            ['name' => 'Nuxt.js', 'category' => 'Frontend'],
            ['name' => 'Tailwind CSS', 'category' => 'Frontend'],
            ['name' => 'Bootstrap', 'category' => 'Frontend'],
            ['name' => 'Sass/SCSS', 'category' => 'Frontend'],
            ['name' => 'Redux', 'category' => 'Frontend'],
            ['name' => 'Webpack', 'category' => 'Frontend'],
            ['name' => 'Vite', 'category' => 'Frontend'],

            // Backend
            ['name' => 'PHP', 'category' => 'Backend'],
            ['name' => 'Laravel', 'category' => 'Backend'],
            ['name' => 'Symfony', 'category' => 'Backend'],
            ['name' => 'Python', 'category' => 'Backend'],
            ['name' => 'Django', 'category' => 'Backend'],
            ['name' => 'Flask', 'category' => 'Backend'],
            ['name' => 'FastAPI', 'category' => 'Backend'],
            ['name' => 'Node.js', 'category' => 'Backend'],
            ['name' => 'Express.js', 'category' => 'Backend'],
            ['name' => 'NestJS', 'category' => 'Backend'],
            ['name' => 'Java', 'category' => 'Backend'],
            ['name' => 'Spring Boot', 'category' => 'Backend'],
            ['name' => 'C#', 'category' => 'Backend'],
            ['name' => '.NET Core', 'category' => 'Backend'],
            ['name' => 'Go', 'category' => 'Backend'],
            ['name' => 'Ruby', 'category' => 'Backend'],
            ['name' => 'Ruby on Rails', 'category' => 'Backend'],
            ['name' => 'Rust', 'category' => 'Backend'],

            // Database
            ['name' => 'MySQL', 'category' => 'Database'],
            ['name' => 'PostgreSQL', 'category' => 'Database'],
            ['name' => 'SQLite', 'category' => 'Database'],
            ['name' => 'MongoDB', 'category' => 'Database'],
            ['name' => 'Redis', 'category' => 'Database'],
            ['name' => 'SQL', 'category' => 'Database'],
            ['name' => 'Oracle', 'category' => 'Database'],
            ['name' => 'Firebase', 'category' => 'Database'],
            ['name' => 'Supabase', 'category' => 'Database'],
            ['name' => 'Elasticsearch', 'category' => 'Database'],

            // DevOps & Cloud
            ['name' => 'Git', 'category' => 'DevOps'],
            ['name' => 'Docker', 'category' => 'DevOps'],
            ['name' => 'Kubernetes', 'category' => 'DevOps'],
            ['name' => 'AWS', 'category' => 'DevOps'],
            ['name' => 'Azure', 'category' => 'DevOps'],
            ['name' => 'Google Cloud', 'category' => 'DevOps'],
            ['name' => 'Linux', 'category' => 'DevOps'],
            ['name' => 'CI/CD', 'category' => 'DevOps'],
            ['name' => 'Jenkins', 'category' => 'DevOps'],
            ['name' => 'GitHub Actions', 'category' => 'DevOps'],
            ['name' => 'Terraform', 'category' => 'DevOps'],
            ['name' => 'Nginx', 'category' => 'DevOps'],

            // Mobile
            ['name' => 'React Native', 'category' => 'Mobile'],
            ['name' => 'Flutter', 'category' => 'Mobile'],
            ['name' => 'Swift', 'category' => 'Mobile'],
            ['name' => 'Kotlin', 'category' => 'Mobile'],
            ['name' => 'Android', 'category' => 'Mobile'],
            ['name' => 'iOS', 'category' => 'Mobile'],

            // AI & Data Science
            ['name' => 'Machine Learning', 'category' => 'AI/Data'],
            ['name' => 'Deep Learning', 'category' => 'AI/Data'],
            ['name' => 'TensorFlow', 'category' => 'AI/Data'],
            ['name' => 'PyTorch', 'category' => 'AI/Data'],
            ['name' => 'Pandas', 'category' => 'AI/Data'],
            ['name' => 'NumPy', 'category' => 'AI/Data'],
            ['name' => 'Scikit-learn', 'category' => 'AI/Data'],
            ['name' => 'OpenCV', 'category' => 'AI/Data'],
        ];

        foreach ($skills as $skill) {
            Skill::firstOrCreate(['name' => $skill['name']], $skill);
        }
    }
}
