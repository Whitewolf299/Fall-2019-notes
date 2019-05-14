/*
Sylvan Brander
4/8/19
id : 0128-23522
*/



#include <iostream>
#include <unordered_map>
#include <cmath>
#include <string>
#include "CsvParser.h"
#include "TreeNode.h"

using namespace std;

//calculate entropy based on a frequency distribution of all 
//outcome levels
double calculateEntropy(const unordered_map<string, int>& outcome_level)
{
   //determine denominator
   int denominator = 0;
   for (auto i : outcome_level)
   {
      denominator += i.second;
   }

   //calculate entropy
   double entropy = 0.0;
   for (auto item : outcome_level)
   {
      double ratio = (double)item.second / denominator;
      double logged = log2(ratio);
      entropy += -ratio * logged;
   }
   return entropy;
}

//builds frequency distribution based on supplied vector of data
unordered_map<string, int> buildFrequencyDistribution(const vector<string>& data)
{
   unordered_map<string, int> distribution{};
   for (auto item : data)
   {
      distribution[item]++;
   }
   return distribution;
}

//allows us to grab a specific column of data from our 2d matrix
vector<string> getObservations(const vector<vector<string>>& matrix, 
   int column)
{
   vector<string> result{};
   for (int i = 0; i < matrix.size(); i++)
   {
      result.push_back(matrix[i][column]);
   }
   return result;
}

//for the given matrix, reduce matrix such that all results
//match the supplied predictor variable on the supplied column
vector<vector<string>> reduceMatrix(
   const vector<vector<string>>& matrix,
   int column,
   string predictor
)
{
   vector<vector<string>> result{};
   for (int i = 0; i < matrix.size(); i++)
   {
      if (matrix[i][column] == predictor)
      {
         result.push_back(matrix[i]);
      }
   }
   return result;
}

int findMaxGain(
   const vector<vector<string>>& matrix, 
   int outcome_column,
   double entropy)
{
   if (matrix.size() == 0)
   {
      return -1;
   }

   vector<double> information_gain{};

   //caculate information gain for each predictor variable
   for (int column = 0; column < matrix[0].size(); column++)
   {
      //skip outcome column
      if (column == outcome_column)
      {
         information_gain.push_back(-1);
         continue;
      }

      vector<string> observations = getObservations(matrix, column);
      unordered_map<string, int> observation_levels = buildFrequencyDistribution(observations);
      double local_entropy = 0.0;
      for (auto level : observation_levels)
      {
         auto reduced_matrix = reduceMatrix(matrix, column, level.first);
         auto reduced_observations = getObservations(reduced_matrix, outcome_column);
         local_entropy += ((double)level.second / observations.size()) *
            calculateEntropy(buildFrequencyDistribution(reduced_observations));
         
      }
      information_gain.push_back(entropy - local_entropy);
      
   }

   //return column with most gain
   int most_gain = 0;
   for (int i = 1; i < information_gain.size(); i++)
   {
      if (information_gain[i] > information_gain[most_gain])
      {
         most_gain = i;
      }
   }
   return most_gain;
}

TreeNode* buildTree(
   const vector<vector<string>>& matrix,
   const vector<string>& predictors,
   const int& outcome_column
)
{
   vector<string> observations = getObservations(matrix, outcome_column);
   double entropy = calculateEntropy(
      buildFrequencyDistribution(observations));

   //base case: 0 entropy
   if (entropy < 0.01)
   {
      TreeNode* node = new TreeNode{};
      node->value = matrix[0][outcome_column];
      return node;
   }

   int col = findMaxGain(matrix, outcome_column, entropy);

   //create new node
   TreeNode* node = new TreeNode{};
   node->value = predictors[col];

   //attach as children all levels of outcome
   vector<string> selected_observations = getObservations(matrix, col);
   auto selected_levels = buildFrequencyDistribution(selected_observations);
   for (auto level : selected_levels)
   {
      auto reduced_matrix = reduceMatrix(matrix, col, level.first);
      node->children[level.first] = buildTree(reduced_matrix, predictors, outcome_column);
   }
   cout << node->value << " ";
   return node;
}

// this is the function the takes the newly created tree and a line of the other 80%
// of the data and finds the supposed answer and see if it is correct 
// we also must make sure that we can actually get to the next node in the tree
// so we have to chck if the the next node to check is actually in our data so if we 
// have an answer that dosent match our options we can stop predicting 

//variables:
//		pv = Predictor variables 
//      root = the root of our perediction tree

void predictor(vector<string>& pv, TreeNode* root, vector<string> headers)
{
	string val = root->value;
	if (root->children.size() < 1)
	{
		pv.push_back(val);
		return;
	}
	int counter = 0, col_num;
	for (auto head : headers)
	{
		if (head == val)
		{
			col_num = counter;
		}
		counter++;
	}
	auto childs = root->children;
	bool check = false;
	for (auto child : childs)
	{
		if (child.first == pv[col_num])
		{
			check = true;
		}
	}

	if (check == true)
	{
		predictor(pv, root->children[pv[col_num]], headers);
	}

	return;
}

int main(void)
{
	//ask for the name of the file containing the data that we are going to use
	// to build our desicion tree
	string data_file_name = "";
	cout << "Please enter the name of the CSV file conataining the data : ";
	getline(cin, data_file_name);


	//parses out the data into a matrix 
	CsvStateMachine parser{ data_file_name };
	vector<vector<string>> data = parser.processFile();

	//separates the names of the columns from the rest of the data 
	vector<string> header = data[0];

	//AC NOTE: very slow.  Consider using STL move to move
	//array elements 1...size() to another structure
	data.erase(data.begin());

	cout << endl << endl << "Please enter the number of the column of the predictor variable : ";
	string col_name;
	int col_num;
	getline(cin, col_name);

	col_num = stoi(col_name);
	unordered_map<string, int> predictor_possiblilites{};
	for (auto preds : data[col_num])
   {
		predictor_possiblilites[preds] = 1;
   }


   TreeNode* root = buildTree(data, header, col_num);
   string test_data_name;
   cout << endl << "Please enter the name of the file you would like to test your data tree on : ";
   getline(cin, test_data_name);

   //parses out the data into a matrix 
   CsvStateMachine parser2{ test_data_name};
   vector<vector<string>> new_data = parser.processFile();
   new_data.erase(new_data.begin());

   //this loop will loop through our data and add a final slot that is our prediction
   // for this partictular set of predictor variables 


   for (int i = 0; i < new_data.size(); i++)
   {
	   predictor(new_data[i], root, header);
   }
   cout << endl << "Please enter the name of the file that we will be outputing to : ";
   getline(cin, test_data_name);

   ofstream   data_out_file(test_data_name);
   header.push_back("Prediction");

   for (auto bits : header)
   {
	   data_out_file << bits << ",";
   }

   for (auto dat : new_data)
   {
	   data_out_file << endl;
	   for (auto things : dat)
	   {
		   data_out_file << things << ",";
	   }
   }

   return 0;
}