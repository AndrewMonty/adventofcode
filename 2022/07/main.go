package main

import (
	"bufio"
	"fmt"
	"log"
	"os"
	"strconv"
	"strings"
)

type File struct {
	name     string
	size     int
	parent   *File
	children []*File
}

func main() {
	input, err := os.Open("input.txt")

	if err != nil {
		log.Fatal(err)
	}

	scanner := bufio.NewScanner(input)
	var currentFile *File

	for scanner.Scan() {
		line := scanner.Text()
		fmt.Println(line)

		if line == "$ cd .." && currentFile.parent != nil {
			currentFile = currentFile.parent
			continue
		} else if strings.HasPrefix(line, "$ cd ") {
			name := strings.SplitAfter(line, "$ cd ")[1]
			if currentFile == nil {
				currentFile = &File{
					name: name,
				}
			} else {
				for _, file := range currentFile.children {
					if file.name == name {
						currentFile = file
						continue
					}
				}
			}
		}

		if !strings.HasPrefix(line, "$") {
			var file *File
			output := strings.Split(line, " ")
			size, err := strconv.Atoi(output[0])
			if err != nil {
				size = 0
			}

			file = &File{
				parent: currentFile,
				name:   output[1],
				size:   size,
			}

			currentFile.size += file.size

			parent := currentFile.parent

			for {
				if parent == nil {
					break
				}

				parent.size += file.size
				parent = parent.parent
			}

			currentFile.children = append(currentFile.children, file)
		}
	}

	// go back up to root
	for {
		if currentFile.parent == nil {
			break
		}

		currentFile = currentFile.parent
	}

	var partOneMatches []*File

	partOneMatches = findPartOneMatches(currentFile, partOneMatches)
	totalSize := 0

	fmt.Println("")
	fmt.Println("Directories under 100000")

	for _, dir := range partOneMatches {
		totalSize += dir.size
		fmt.Println(dir.name + " size: " + strconv.Itoa(dir.size))
	}

	fmt.Println("")
	fmt.Println("Total size of matches: " + strconv.Itoa(totalSize))

	totalUsedSpace := currentFile.size
	availableSpace := 70_000_000 - totalUsedSpace
	requiredSpace := 30_000_000 - availableSpace

	fmt.Println("")
	fmt.Println("Total disk size: 70000000")
	fmt.Println("Total used space: " + strconv.Itoa(totalUsedSpace))
	fmt.Println("Total available: " + strconv.Itoa(availableSpace))
	fmt.Println("Required space: " + strconv.Itoa(requiredSpace))

	var partTwoMatches []*File
	var smallestCandidate *File
	partTwoMatches = findPartTwoMatches(requiredSpace, currentFile, partTwoMatches)

	fmt.Println("")
	fmt.Println("Candidates for deletion")

	for _, dir := range partTwoMatches {
		if smallestCandidate == nil || smallestCandidate.size > dir.size {
			smallestCandidate = dir
		}
		fmt.Println(dir.name + " size: " + strconv.Itoa(dir.size))
	}

	fmt.Println("")
	fmt.Println("Smallest candidate: " + smallestCandidate.name + " (" + strconv.Itoa(smallestCandidate.size) + ")")
}

func findPartOneMatches(file *File, matchingDirectories []*File) []*File {
	if file.children == nil {
		return matchingDirectories
	}

	if file.size <= 100_000 {
		matchingDirectories = append(matchingDirectories, file)
	}

	for _, child := range file.children {
		matchingDirectories = findPartOneMatches(child, matchingDirectories)
	}

	return matchingDirectories
}

func findPartTwoMatches(requiredSpace int, file *File, matchingDirectories []*File) []*File {
	if file.children == nil {
		return matchingDirectories
	}

	if file.size >= requiredSpace {
		matchingDirectories = append(matchingDirectories, file)
	}

	for _, child := range file.children {
		matchingDirectories = findPartTwoMatches(requiredSpace, child, matchingDirectories)
	}

	return matchingDirectories
}
