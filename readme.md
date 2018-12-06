

Triple Search – A Meta Search Engine

M.Sc. Software Engineering Project


Implementation of a Meta Search Engine using the Borda Count Aggregation Method to rank results.


 
Introduction
A Meta Search engine transmits a user’s search simultaneously to several individual search engines and their databases of web pages and gets results from all the search engines queried. In this paper I describe Triple Search, an experimental Meta Search engine that provides simultaneous access to three major conventional, crawler-based search engines, Bing, Entireweb and Blekko. 

I have provided a GUI for searching the search engines with different display methods available to the user to choose.   The interface supports Boolean search capabilities of the engines and the user can also choose whether to turn on stemming and stop word removal of their query.  In order to rank the results obtained, I have made use of the well known Borda Count rank aggregation strategy and evaluated the results obtained based on the highest points scored.  A publicly accessible interface for the new Triple Search can be found at http://csicluster.ucd.ie/~10268898/FINAL/



Motivation
The primary motivation behind this project was to develop a simple Meta Search engine capable of providing the user with a comprehensive set of relevant results.  The internet contains a huge unstructured body of information.  No one search engine indexes the entire web.  Triple Search aims to provide the user with a more comprehensive set of results than one would get by just searching one search engine.  If a result is found in more than one engine it will have a higher score and hopefully these results will be most relevant to the user.  By searching more than one engine at a time will hopefully enable Triple Search to cover a larger portion of the web


Challenges 
One of the main challenges when designing this software project was for the aggregation method to be as quick as possible.  Speed is critical on the internet and a user should not have to wait an unreasonable amount of time for results to be parsed from the various engines or else they will simply go elsewhere to search.

Aims
One of the main aims of this project is for the final Meta Search engine to score better mean average precision scores than non aggregated methods.  This will hopefully show people who would normally only use one search engine, the benefits of using multiple search engines on a query.












FUNCTIONAL REQUIREMENTS

Tokenisation
Triple Search carries out tokenisation on the user entered query.  Tokenisation is the process of breaking a stream of text up into words, phrases, symbols, or other meaningful elements called tokens.   Text is parsed, lowercased and all punctuation removed. The list of tokens becomes input for further processing


Complex Search Ability
The Internet is a vast computer database.  As such, its contents must be searched according to the rules of computer database searching. Much database searching is based on the principles of Boolean logic. Boolean logic refers to the logical relationship among search terms, and is named after the British-born Irish mathematician George Boole. 
Boolean logic consists of three logical operators:
•	OR
•	AND
•	NOT
Triple Search supports the above search types.

Stop Word Removal
Stop words are common words that carry less important meaning than keywords. Usually search engines remove stop words from a keyword phrase to return the most relevant result. 
Triple Search can implement stop word removal.

Stemming
A stemming algorithm lets you reduce each English input word to its basic root or stem (e.g. ‘walking’ to ‘walk’) so that variations on a word (‘walks’, ‘walked’, ‘walking’) are considered equivalent when searching. The stems can then be used in a search query rather than the original words, which generally (but not always) results in more relevant search results.  Triple Search also supports stemming.


Results Display
When using Triple Search the user can select whether or not to have their results returned in an aggregated display or a non-aggregated display.







DESIGN

Figure1. System Architecture of Triple Search

 

The architecture of the software together with the steps involved in answering a query are illustrated in Figure 1.  

After the user specifies their query using the web interface, the query undergoes some processing before it is submitted to the underlying search engines.  Depending on the users choice stemming and stop word removal might form part of this pre processing stage.  

The query is then sent to the engines and the list of results is returned and parsed using JSON.  If the user has chosen Meta Search scores are assigned to the results based on their positions in the results lists for the various search engines.   Scores are added for URLs that are found in more than one engine. 

If the user has chosen Non Aggregated the results are simply listed by each search engine. Meta Search Results are listed from highest score to lowest score.  The search bar is accessible at all stages in the process.

The software is composed of five major parts as described in the following subsections:


1.	Web user interface

This component deals with the creation of the layout for query and results.  It is a simple user-friendly interface where the user can type in a query.  The user can choose whether they want results to be returned in an aggregated manner by using the Meta Search radio button or Non-Aggregated by using the corresponding radio button.  By default Meta Search is always ticked.  There is also a check box which the user can tick to turn on stemming and stop word removal.  The web user interface has been be developed in HTML and uses a CSS style sheet to format the output, while the rest of the software has been developed in PHP .


 


2.	Query Pre Processing Stages:

•	Tokenisation
When a user enters a query using the Triple Search interface and clicks search, tokenisation is the first task that is carried out on the users query.  In Triple Search when the user clicks the search button the PHP script first checks to make sure that the user has entered a query.  If no query has been entered the user receives an error message telling them that no query has been entered.

 Providing that a query has been entered, the user entered string is first converted to lowercase and any white space is trimmed from the query.  The in-built PHP function preg_replace is then used to search the string for various predefined punctuation marks which are removed if found in the string and replaces them with empty space.  The tokens are now ready for further processing.



•	Boolean Search
Two of the underlying search engines used in Triple-Search, Bing and Entireweb, support Boolean Search capabilities.  The third engine, Blekko unfortunately does not.  
To use Boolean search with Triple-Search the user must enter the search type in the format AND, OR, or NOT.  Input is not case sensitive as the query is converted to lowercase in the tokenisation stage anyway.  The user entered query is checked to see does it contain these words.  If the query does contain some of these key words they are replaced using the PHP preg_replace function as follows:

•	and becomes +  eg. football and  Manchester- -> football  + manchester
•	or is converted to uppercase OR.  Eg. football OR  manchester
•	not becomes -  eg. football not Manchester-->football  -manchester



•	Stop Word Removal
The user interface for Triple Search allows the user to tick a checkbox which enables them to use this feature if they so wish.  If the user decides to use this feature the appropriate PHP script is run.  Stop Word removal is implemented within the script by making a call to a function for stop word removal on the user entered string.  This function loads a text file containing a list of words to be removed from the users query into a PHP array. 

The users query is then compared to the list of stop words and if any of the words in the users query are found in the stop word list they are removed.  Common stop words include words like a, the, this etc. 

The aim of stop word removal is to improve search performance but it is not without its problems.  For instance if a user searches for “used car parts”, stop word removal removes the words “used” and “parts” which are critical to the precision of the search.  Used in the right manner however stop word removal can be a good thing especially for long ambiguous queries.  It is important to give the user a choice as to whether or not they want to use this function.


•	Stemming
Stemming is implemented as part of the Stop Word Removal function.  In this project I used the famous Porter Stemming Algorithm which is available freely on the internet.   The script is very easy to use and requires making a call to the Porter Stemming Class on the query which then stemmed the words.   An important point to note with regards stemming is that words such as “family” were stemmed to “famil” which is obviously not a real word.  For this reason I decided to search for both the original query and the stemmed version so a query for “family” would search for “family or “ amily”.

 
3.	Parallel Page Retrieval
Triple Search uses a PHP form to take a query entered by the user and submit it to the various search engines involved.  The built-in $_POST function is used to collect values from a form sent with method=”post”.
Information sent from a form with the POST method is invisible to others and has no limits on the amount of information to send.
PHP_SELF is a variable that returns the current script being executed. This variable returns the name and path of the current file (from the root folder). 

After carrying out the query pre processing stages the next step in converting a user entered query into results involves sending the users query to each of the underlying search engines.  This is done by using parallel page retrieval.  Each search engine has its own path to which the query must be sent.  Each path requires an API key which is obtained from the companies involved.  Other details which must be specified in the query path are the number of results to return (limited to 50-100), as well as the format in which to return the results.  The PHP function file_get_contents is used to return the results file from each engine to a string. 

 Results are returned in JSON  (JavaScript Object Notation) format.   The JSON results are then easily decode into PHP associative arrays for further processing using the json_decode function.


4.	Aggregation
The heart of a Meta Search Engine is the rank aggregation algorithm it uses.  For this project I decided to use the Borda Count method to rank the results.  This aggregation method is implemented in Triple Search as follows.  When the results are parsed to the PHP multi-dimensional associative arrays, each result set is then looped through using a foreach loop.  

As Triple Search returns 50 results from each engine the value of score is initialised to 51.  On each iteration of the foreach loop the value of score is decremented by 1.  The score a document receives is based on its position in the list of documents returned by the search engines.  

The top ranked document receives a score of 50 and the lowest ranked document in the array, a score of 1.  Once each result set has had scores assigned to its documents the next step in the aggregation process is to compare the results from each engine to each other.   The comparison is based on the URL of each document.  If the URLs match their corresponding scores are added all the documents details are stored in a new array.


Figure 2.
 

 As Figure 2. Shows there are several combinations of engine for a result to be found in.  These are:
•	Bing, Blekko and Entireweb
•	Bing and Blekko
•	Bing and Entireweb
•	Blekko and Entireweb
•	Bing
•	Blekko
•	Entireweb

Triple Search first compares the results of 2 engines, Bing and Blekko for matching URLs.   If matches are found these results are stored in a new associative array with their combined score and details.  

This array is then compared to Entireweb’s result set and if matching URLs are found they are stored in a new associative array with results common to all 3 engines.

Bing and Entireweb are also compared to each other for matching URLs as well as Blekko and Entireweb.  If any matching URLs are found scores are added and the data stored in new arrays.

Once all possible outcomes have been gathered to their respective associative arrays, Triple Search then makes use of some of PHPs inbuilt array functions.  The original arrays containing results with scores that have not been added are merged to form one large array called MERGED_ORIGINAL.

The new arrays containing scores which have been added are merged in to one large array called MERGED_SCORES and duplicates are removed using a function.  This array is then merged with the original array containing documents whose score had not been added and again duplicates are removed.  We are then left with our final array which is sorted by score using another function form high to low.  This final array now contains all documents ranked by score and is now ready to be displayed to the user.


If the user selects Non-Aggregated the process for getting results ready for display is much shorter.  No scores need to be assigned or added to documents.  A foreach loop goes through each JSON parsed result set and takes the values to be displayed to the user and puts them in a new array along with the name of the Engine to distinguish results to the user at the end.  The results are then ready to be displayed to the user



5.	Display Results
Figure 3 shows the typical result of a query.

Depending on the search choice chosen results will be displayed in either an aggregated list or non aggregated list form.  

Both display methods show the query entered at the top of the result list together with the time taken to return the results.  The results are presented in an ordered manner.  Each title is also a link to the URL of the page.  A summary of the page is provided to the user as well.

If the results are being displayed in an aggregated display, a list of the search engines that the result has been found on is printed in red under the summary.  The score the result achieved is also displayed to the user.

Non aggregated results are printed by search engine with the top 50 results of Bing displayed first, followed by the top 50 results of Entireweb and finally the top 50 results of Blekko.

The aggregated results are displayed to the user by calling a PHP function to print the final array within the script.  All results are formatted using an external CSS style sheet linked to the corresponding page.

Figure 3.0

 




















TECHNOLOGIES USED
•	PHP

PHP is a general-purpose scripting language originally designed for web development to produce dynamic web pages.  For this purpose, PHP code is embedded into the HTML source document and interpreted by a web server with a PHP processor module, which generates the web page document.    

Triple Search has been developed entirely using PHP.  As PHP has an extensive collection of inbuilt functions for dealing with arrays I felt it was the perfect choice to simply use these functions to manipulate the data in the PHP multi-dimensional associative arrays.  There is also a wealth of information to be found on the internet regarding PHP and I found the official PHP site to be an extremely useful resource.  


•	NetBeans IDE  7.0

All code was written using the NetBeans 7.0 Integrated Development Environment.  NetBeans is an award-winning integrated development environment available for Windows, Mac, Linux, and Solaris. The NetBeans project consists of an open-source IDE and an application platform that enable developers to rapidly create web, enterprise, desktop, and mobile applications using the Java platform, as well as PHP and other languages. 


•	XAMPP

XAMPP’s name is an acronym for:
•	X (to be read as “cross”, meaning cross-platform)
•	Apache HTTP Server
•	MySQL
•	PHP
•	Perl

The program is released under the terms of the GNU General Public License and acts as a free web server capable of serving dynamic pages. XAMPP  is available for Microsoft Windows, Linux, Solaris, and Mac OS X, and is mainly used for web development projects. This software is useful while you are creating dynamic web pages using programming languages like PHP .  I used XAMPP to test Triple Search locally.  I also made use of its MySQL feature during evaluation


•	phpMyAdmin and MySQL

phpMyAdmin is an open source tool written in PHP intended to handle the administration of MySQL with the use of a Browser. It can perform various tasks such as creating, modifying or deleting databases, tables, fields or rows; executing SQL statements; or managing users and permissions.   I used phpMy admin to create a database to store the tables used in the evaluation of Triple Search.  I also used it to create the various tables needed for the evaluation.

MySQL is a popular choice of database for use in web applications, and is a central component of the XAMMP software stack. 



PROBLEMS ENCOUNTERED

When I started developing Triple Search I was completely inexperienced in PHP programming so I encountered many problems along the way.

The first problem I encountered was understanding the array structures returned using the json_decode () function.  To better understand what the arrays contained I had to use a function in PHP called print_r ().  Placed between echo “<pre>” statements this function prints out in human readable form to the screen the contents of an array or any other variable specified between the brackets.  I found this feature particularly useful for debugging my code and helping me to understand what I was doing.  I also used the function var_dump () which is similar to the print_r () function to help me out when coding this project.

I also faced problems when trying to implement the Borda Count Aggregation method.  If one of the engines returned no results for a query error messages would appear as my implementation of the Borda Method relied on there being values stored in arrays.  To solve this problem I used if statements before carrying out certain sections of the code to check if the array actually existed first.  I used isset() and is_array() as the conditional statements for the if statements and this solved the problem.

I also faced problems trying to implement Triple Search’s stemming feature.  The stemmed version of many words often resulted in searches for misspelt words.  This affected the number of results being returned, with some engines returning no results.  My solution to this problem was to search for both the original word and the stemmed version.  

When evaluating Triple Search’s performance against Google API, I also encountered a few problems.  The main problem I faced was the fact the Google API had been deprecated and was difficult to use compare to the APIs in Triple Search.  The Google API would only return 8 results per page for a maximum of 8 pages. This meant that I had to make 8 simultaneous calls to the API for results specifying an offset of 8 each time.  This solution worked but it did mean I had to write quite a bit of extra code for it to work.  It also meant it was quite hard to read the code with everything repeated 8 times. 







EVALUATION
Once Triple Search was created it was time to evaluate its performance against Google.  To do this I created a separate site specifically for evaluation purposes.  For the evaluation I used phpMyadmin to create a database for the evaluation containing tables to store Precision, Recall and Average Precision figures for each query and aggregation method.  

The screen shot below shows the layout of the Evaluation site.

 

On the evaluation site when a user enters a query and clicks go, a connection is made to a MySQL database which stores the query along with its precision, recall and average precision scores.

 
The details which have been entered into the database are also displayed on screen to the user.
•	PRECISION
Precision measures quality of results retrieved.  Precision is calculated by dividing the total number of relevant documents returned by Triple Search over the total number of documents it returns.

Precision = No of Relevant Docs Retrieved/Total Retrieved Documents

For a document to be relevant it must be found in the list of documents returned by Google for the same query.  When calculating precision the evaluation site also sends the user query to the Google web search API.  This API only returns 8 results per page and a maximum of 8 pages of results.

In order to return the maximum 64 results involved making 8 simultaneous requests to the API and specifying an offset of 8 for each result.  For this reason the evaluation site is slower at returning results than Triple Search.  The URLs of the documents retrieved by TRIPLE search are compared to those returned by Google and if any match they are counted as relevant documents and the precision is worked out accordingly.


•	RECALL
Recall measures quantity of results retrieved.  Recall is calculated by dividing the number of relevant documents retrieved by Triple Search over the Total possible number of relevant documents which in this case was 64.
 
Recall = No of Relevant Docs Retrieved/Total Relevant Docs


•	AVERAGE PRECISON
Precision does not give a full account of how precise a Search Engine really is as it does not take into account where the relevant documents were actually found in the returned list.  

Average Precision= sum of precision at each recall point/no of relevant documents retrieved

Average Precision gives a truer reflection on search engine performance.  If a query’s relevant documents are found near the top of the returned list it will have a higher average precision than a query whose results are found near the bottom of the returned list.


•	MEAN AVERAGE PRECISION (MAP)
The Mean Average Precision for a set of queries is the mean of the average precision scores for each query. It is the average of all the average precision scores of each query.  MAP is commonly used to compare the performance of 2 systems.










RESULTS
The evaluation site also displays the results for each query stored in the database together with the MAP score for the aggregation method and the average recall.

 


The results for the various aggregation methods tested with the 50 queries were as follows:

AGGREGATED WITHOUT STEMMING AND STOPWORD REMOVAL
MEAN AVERAGE PRECISION	0.31730
AVERAGE RECALL	0.24718


AGGREGATED WITH STEMMING AND STOPWORD REMOVAL
MEAN AVERAGE PRECISION	0.21108
AVERAGE RECALL	0.17593


NON AGGREGATED WITHOUT STEMMING AND STOP WORD REMOVAL
MEAN AVERAGE PRECISION	0.2828
AVERAGE RECALL	0.31375


NON AGGREGATED WITH STEMMING AND STOP WORD REMOVAL
MEAN AVERAGE PRECISION	0.19830
AVERAGE RECALL	0.20312





AGGREGATED v NON AGGREGATED

The tests for precision, recall, average precision and MAP over the 50 queries indicate that the aggregated results performed better than the non aggregated.  I would attribute this to the fact that after carrying out aggregation on the results a higher percentage of the relevant results would be found near the top of the returned list.  


The average recall was better for the non aggregated results than the aggregated results.  I believe the reason for this was that duplicate results are removed from the aggregated list so less result are returned but as the MAP scores show these returned results are of a higher precision than those of the non aggregated results

STOP WORD REMOVAL AND STEMMING TURNED ON

Both MAP and Recall scores decreased significantly for the aggregated results when stemming and stop word removal was turned on.  Originally I tested the queries by searching for just the stemmed version of the word.  Stemming caused a lot of the words to change to wrongly spelled versions of the stem of the word.  This meant that a lot of the queries were returning very few results.  The Blekko API was not returning any results for a lot of the stemmed queries.

As a result I decided to search for the original query with stop words removed together with the stemmed version. This improved the number of results the engines were returning.  The new results contained fewer relevant results however and this affected its performance in a big way.

The story was much the same when stemming and stop word removal was turned on for the non aggregated results.  I believe the original query was changed to much for stemming to be a success and improve the recall.








CONCLUSIONS 

After completing this project I feel that I have greatly improved my programming skills.  The project has taught me many valuable lessons that I will keep with me in to the future.  I found planning very important in this project.  All my ideas were written down on paper before even starting to code and I felt this made coding much easier when I had a clear idea of what I was trying to achieve.

The project has also given me a thorough understanding of PHP which I hope to use on more projects in the future.  I also experimented with PHP and MySQL databases on this project and found some great benefits with using them.

With regards Triple Search I was pleased to see from the evaluation that the Borda Count Aggregation method for ranking documents worked.  Over the 50 queries the Borda Count Aggregation method scored the highest average precision.  I was delighted with this result and it showed how ranking documents in a positional manner can improve overall precision.





FUTURE WORK

The main goal of the project has been the development of a Meta Search Engine using the Borda Count method to rank the results and
Possible future extensions of Triple Search include:

• Improving the web user interface with new enhancements (like spell check, query rewrite etc.)
• Implementing k-means clustering of the results.
• Pagination of the Results.






