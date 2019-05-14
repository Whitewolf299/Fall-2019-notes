/* 
This program will take in a file wit a bunch of nodes and a file of destinations that we must "deliver"to.
the program will then calculate the shortest possible path to get to all nodes in the delivery sub set. 
(tier 3) : shows the actual path and time it takes to travel to all of the nodes

Sylvan Brander

Colaborator:
Zach Pole

Pa3

last modified : 3/11/19
*/


#include "CityGraph.h";
#include "CsvParser.h"
#include <vector>
#include <queue>
#include <iostream>
#include <fstream>
#include <string>
#include <unordered_map>

using namespace std;

int main(void)
{
	CityGraph graph{};
	CityGraph reduced_graph{};
	CityGraph tier_three_graph{};
	unordered_map<string, int> has_seen{};
	unordered_map<string, string> throw_away{}, final_paths{};

	cout << endl << "What is the name of the file that contains the Map information: ";
	string file_name;
	getline(cin, file_name);
	//Example of how to parse a CSV file for graph building
	CsvStateMachine csm{ file_name };
	vector<vector<string>> data = csm.processFile();

	for (auto vects : data)
	{

		if (has_seen.find(vects[0]) == has_seen.end())
		{
			graph.addVertex(vects[0]);
			has_seen[vects[0]]++;
		}
		if (has_seen.find(vects[1]) == has_seen.end())
		{
			graph.addVertex(vects[1]);
			has_seen[vects[1]]++;
		}

		graph.connectVertex(vects[0], vects[1], stoi(vects[2]), true);
	}

		string answer, deliv_file, Deliveries;
		vector<string> to_deliver{};


		//determins where we get the list of nodes that we are delivering to 
		//both paths end up with us having a vector of strings called to_deliver
		// the strings are the names of the nodes 

			// this path allows the user to enter the ame of a file that contains all the of the name of the deliver locations

			cout << endl << "What is th name of the file that cotains the delivery locations : ";
			getline(cin, deliv_file);
			ifstream locations_file(deliv_file);
			string locations;
			if (locations_file.is_open())
			{
				while (locations_file.eof() == false)
				{
					getline(locations_file, locations);
					if (locations != "")
					{
						to_deliver.push_back(locations);
					}
				}
			}
			locations_file.close();
		


		//adds all of the nodes to our reduced grapgh 

		int i = 0;
		for (auto deliveries : to_deliver)
		{
			reduced_graph.addVertex(deliveries);
		}


		//for all nodes in our reduced_graph we connect the together 

		for (auto deliveries : to_deliver)
		{
			auto connections = graph.computeShortestPath(deliveries);


			for (int x = i + 1; x < to_deliver.size(); x++)
			{
				reduced_graph.connectVertex(deliveries, to_deliver[x], connections[to_deliver[x]], true);
			}


			i++;
		}

		// rgv stands for reduced graph vectors
		vector<vector<string>> rgv{};


		auto mst = reduced_graph.computeMinimumSpanningTree(to_deliver[0], rgv);

		int total = 0;
		for (auto connections : rgv)
		{
			total = total + stoi(connections[2]);
		}

		cout  << endl << endl << "The total travel time it takes to get to all of the delivery points is : [ " << total << " ] Arbitrary units of time " << endl << endl;

		/*

		my failed attempt at tier three

		unordered_map<string, int> froms{}, tos{}, all_nodes{};


		for (auto vects : rgv)
		{
			tos[vects[0]]++;
			froms[vects[1]]++;
			if (all_nodes.find(vects[0]) == all_nodes.end())
			{
				all_nodes[vects[0]]++;
			}
			if(all_nodes.find(vects[1]) == all_nodes.end())
			{
				all_nodes[vects[1]]++;
			}
		}

		string starting_name;
		for (auto name : all_nodes)
		{
			if (froms.find(name.first) == froms.end())
			{
				starting_name = name.first;
			}
		}


		reduced_graph.computeShortestPath(starting_name, final_paths);



		cout << "Directions : " << endl;

		
		To finish i need to create a function or a method that allows the computer to take the smallest route possible
		we have:
		dirrectioins :" where each node was pointed at from
		

		//taking in a an unordered map telling you how many nodes one node connects to, if we can find the heviest node from that fork or at least one that is not connected to
		//any other nodes

		*/


	return 0;
}