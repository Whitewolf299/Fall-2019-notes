#include "PA1.h"


//PA #1 TOOD: Generates a Huffman character tree from the supplied text
HuffmanTree<char>* PA1::huffmanTreeFromText(vector<string> data)
{
	if (data.size() < 1)
	{
		return new HuffmanTree<char>{' ', ' '};
	}

    //Builds a Huffman Tree from the supplied vector of strings.
    //This function implement's Huffman's Algorithm as specified in the
    //book.
    //In order for your tree to be the same as mine, you must take care 
    //to do the following:
    //1.	When merging the two smallest subtrees, make sure to place the 
    //      smallest tree on the left side!
	//store frequencies in hashtable

	unordered_map<char, int> frequencies{};

	for (auto word : data)
	{
		for (auto ch : word)
		{
			frequencies[ch]++;
		}
	}


	//maintains huffman tree forest 
    priority_queue < HuffmanTree<char>*, vector<HuffmanTree<char>*>, TreeComparer> forest{};

	for (auto kvp : frequencies)
	{
		forest.push(new HuffmanTree<char>(kvp.first, kvp.second));
	}
	
	//-----------------------------------------------------------------------------
	// this takes two trees and combines them and simaltaniously pushes hem back into 
	// the forest we must do this untill there are only one tree left in the forest
	while (forest.size() > 1)
	{
		HuffmanTree<char>* smaller = forest.top();
		forest.pop();
		HuffmanTree<char>* larger = forest.top();
		forest.pop();
		forest.push(new HuffmanTree<char>{ smaller, larger });// the smaller tree must be on the left
	}
    return forest.top();
	//----------------------------------------------------------------------------------------
}

void huffmanTreeFromMapHelper(string mapping, char value, HuffmanInternalNode<char>* root)
{

	if (mapping.size() < 2)
	{
		if (mapping.front() == '0')
		{
			root->setLeftChild(new HuffmanLeafNode<char>{ value, 1});
			return;
		}
		else
		{
			root->setRightChild(new HuffmanLeafNode<char>{ value, 1 });
			return;
		}
	}
	else 
	{
		if (mapping.front() == '0')
		{
			if (root->getLeftChild() == nullptr)
			{
				root->setLeftChild(new HuffmanInternalNode<char>(nullptr,nullptr));
				huffmanTreeFromMapHelper(mapping.substr(1,mapping.size()), value, dynamic_cast<HuffmanInternalNode<char>*>(root->getLeftChild()));
			}
			else
			{
				huffmanTreeFromMapHelper(mapping.substr(1, mapping.size()), value, dynamic_cast<HuffmanInternalNode<char>*>(root->getLeftChild()));
			}
		}
		else
		{
			if (root->getRightChild() == nullptr)
			{
				root->setRightChild(new HuffmanInternalNode<char>(nullptr, nullptr));
				huffmanTreeFromMapHelper(mapping.substr(1, mapping.size()), value, dynamic_cast<HuffmanInternalNode<char>*>(root->getRightChild()));
			}
			else
			{
				huffmanTreeFromMapHelper(mapping.substr(1, mapping.size()), value, dynamic_cast<HuffmanInternalNode<char>*>(root->getRightChild()));
			}
		}
	}
	return;
}

//PA #1 TODO: Generates a Huffman character tree from the supplied encoding map
//NOTE: I used a recursive helper function to solve this!
HuffmanTree<char>* PA1::huffmanTreeFromMap(unordered_map<char, string> huffmanMap)
{
	HuffmanTree<char>*  New_tree = new HuffmanTree<char>{ new HuffmanInternalNode<char>(nullptr, nullptr)};

	for (auto maps : huffmanMap)
	{
		huffmanTreeFromMapHelper(maps.second, maps.first, dynamic_cast<HuffmanInternalNode<char>*>(New_tree->getRoot()));
	}


    //Generates a Huffman Tree based on the supplied Huffman Map.Recall that a 
    //Huffman Map contains a series of codes(e.g. 'a' = > 001).Each digit(0, 1) 
    //in a given code corresponds to a left branch for 0 and right branch for 1.
    return New_tree;
}


void huffmanEncodingmapfromtreehelper(
	unordered_map<char, string>& map,
	HuffmanNode<char>* node,
	string encoding)
{
	if (node->isLeaf() == false)
	{
		//not a leaf, make recursive call
		HuffmanInternalNode<char>* root =
			dynamic_cast<HuffmanInternalNode<char>*>(node);
		huffmanEncodingmapfromtreehelper(
			map,
			root->getLeftChild(),
			encoding + "0"
		);
		huffmanEncodingmapfromtreehelper(
			map,
			root->getRightChild(),
			encoding + "1"
		);
		return;
	}
	else
	{
		// this is a leaf. This means that we have a complete mapping for that charecter
		HuffmanLeafNode<char>* root = dynamic_cast<HuffmanLeafNode<char>*>(node);
		map[root->getValue()] = encoding;
	}
}
//PA #1 TODO: Generates a Huffman encoding map from the supplied Huffman tree
//NOTE: I used a recursive helper function to solve this!
unordered_map<char, string> PA1::huffmanEncodingMapFromTree(HuffmanTree<char> *tree)
{
	unordered_map<char, string> result{};
	huffmanEncodingmapfromtreehelper(result, tree->getRoot(), "");
    return result;
}

//PA #1 TODO: Writes an encoding map to file.  Needed for decompression.
void PA1::writeEncodingMapToFile(unordered_map<char, string> huffmanMap, string file_name)
{
    //Writes the supplied encoding map to a file.  My map file has one 
    //association per line (e.g. 'a' and 001 would yield the line "a001")
	ofstream outputmapping(file_name);
	if (outputmapping.is_open())
	{
		for (auto instance : huffmanMap)
		{
			outputmapping << instance.first + instance.second << endl;
		}
	}
	else 
	{
		cout << "File could not be opened" << endl;
	}

	return;
}

//PA #1 TODO: Reads an encoding map from a file.  Needed for decompression.
unordered_map<char, string> PA1::readEncodingMapFromFile(string file_name)
{
    //Creates a Huffman Map from the supplied file.Essentially, this is the 
    //inverse of writeEncodingMapToFile.  
	ifstream input_file(file_name);
    unordered_map<char, string> result{};
	string the_input;
    
	while (input_file.eof() == false )
	{
		getline(input_file, the_input);
		if (the_input == "")
		{
			break;
		}
		result[the_input.front()] = the_input.substr(1,the_input.size());
	}
	return result;
}

//PA #1 TODO: Converts a vector of bits (bool) back into readable text using the supplied Huffman map
string PA1::decodeBits(vector<bool> bits, unordered_map<char, string> huffmanMap)
{
    //Uses the supplied Huffman Map to convert the vector of bools (bits) back into text.
    //To solve this problem, I converted the Huffman Map into a Huffman Tree and used 
    //tree traversals to convert the bits back into text.
    ostringstream result{};
	for (auto bit : bits)
	{
		if (bit == false)
		{
			result << '0';
		}
		else
		{
			result << '1';
		}
	}
    return result.str();
}

//PA #1 TODO: Using the supplied Huffman map compression, converts the supplied text into a series of bits (boolean values)
vector<bool> PA1::toBinary(vector<string> text, unordered_map<char, string> huffmanMap)
{
    vector<bool> result{};
	for (auto word : text)
	{
		for (int i = 0; i < word.size(); i++)
		{
			while (huffmanMap[word[i]].size() > 0)
			{
				if (huffmanMap[word[i]].front() == '0')
				{
					result.push_back(false);
				}
				else
				{
					result.push_back(true);
				}
				huffmanMap[word[i]].erase(0, 1);
			}

		}
	}
    return result;
}