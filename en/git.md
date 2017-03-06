# Git Guide

[Since 0.5.0]

- [Git Workflow](#git-workflow)

<a name="git-workflow"></a>
## Git Workflow

Everyone is welcome to contribute to the Pletfix framework. 
Would you solve something more elegantly in the framework? Or are you missing a function? 
Then fork the repository and realize your ideas as follows:

1. Fork the original repository.
	
	Einfach auf der github-Seite auf den Fork-Button klicken.

2. Clone your fork
    
    ~~~
    git clone <URL of your fork>
    git remote add myfork <URL of your fork>
    ~~~
   
3. Choose the Branch:
    
    ~~~
    git checkout <Branch X.Y.Z>
    ~~~
    
    Which Branch?
    - Bug Fixes:
        - **All** bug fixes should be sent to the latest stable branch. 
    - New Features
        - **Minor** features that are **fully backwards compatible** with the current Pletfix release may be sent to the **latest stable branch**.
        - **Major** features should always be sent to the **master branch**, which contains the upcoming Pletfix release.

	&nbsp;
    
3. Do your work and push the changes in the fork.
    
    ~~~
	(work)
	git commit -m "my comments"
	(work)
	git commit -m "my comments"
	...
	git push -u myfork <Branch X.Y.Z>
    ~~~
	
4. Nochmals mit dem Original Repository abgleichen
    
    ~~~
	git checkout master
	git pull origin
	git checkout <Branch X.Y.Z>
	git merge master	
    ~~~
	
	Falls Konflikte auftreten:
		(Konflikte durch manuelles Editieren der betroffenen Dateien lösen.)
		
		~~~
		git add <dateiname>				
		git diff feature_1 feature_2
        ~~~
	
5. Mehrere Commits zu einem einzigen zusammen packen
    
    ~~~
	git rebase -i
	~~~

6. Make a Pull Request
	
	Auf der github-Seite auf "New pull request" klicken und Anweisungen folgen.	
