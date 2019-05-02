Time2Code Système de Renderer - <h1>Bienvenue, Liste des exercices !</h1>

<ul>
    <li><a href="
         <?= $router->generateURI('exercise.show', ['slug' => 'first-exercise']); ?>
                ">"Exercice 1</a></li>
    <li><a href="
         <?= $router->generateURI('exercise.show.id', ['slug' => 'Exercie-avec-identification', 'id' => 34]); ?>
                ">Exercice 1 avec id</a></li>
    <li>Exercice 1</li>
    <li>Exercice 1</li>
    <li>Exercice 1</li>
</ul>