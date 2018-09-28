# THE CODING QUESTIONS

## AnagramFinder

#### How long it took:

I spent about 30 mins on this one. Really 40, but those first 10 were spent setting up the environment w/ unit testing/etc.

#### How to run

From the root directory run: `php RunAnagramFinder.php`

## Boggle

#### How long it took:

I lost a little track of time here because I was having too much fun. I probably spent two hours all in all. Once I started down the bath of trying to implement the word search iteratively, rather than recursively, I wanted to see it through.

If I had more time I would have liked to probably wrap all of the searching functionality (i.e.: `wordIsInGameBoard` and `getGameBoardLetterIndices`) in a separate class called `SearchableMatrix` or something like that. That would clean up the `Boggle` class as well as allow me to more easily break up `wordIsInGameBoard` into multiple methods that encapsulate specific parts of the logic, making the code more easily modifiable and unit testable going forward.

I also realize I could do this recursively and it'd look cleaner but I tend to avoid recursive functions because when they go wrong, they go WRONG.

Also, due to not wanting to spend any longer due to the time constraints, I do worry that there may be a few bugs left in the `wordIsInGameBoard` as it is a fairly convoluted iterative algorithm, but thanks to the unit tests I know that at least several use cases work.

#### How to run

From the root directory run: `php RunBoggle.php [word]`

## Unit Tests

I love unit tests. They help me develop. They're also probably why I took a little longer on these tasks. If you'd like to run them:

* `php composer.phar install`
* `cd tests`
* `sh run-tests.sh`

# The Design Question

I have uploaded a PDF containing my thoughts on that section, which you can find in `/docs`.