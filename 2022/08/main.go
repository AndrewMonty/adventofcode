package main

import (
	"bufio"
	"fmt"
	"log"
	"os"
	"strconv"
)

type Tree struct {
	x      int
	y      int
	height int
}

func main() {
	var grid [][]int

	input, err := os.Open("input.txt")

	if err != nil {
		log.Fatal(err)
	}

	scanner := bufio.NewScanner(input)

	for scanner.Scan() {
		row := textToSlice(scanner.Text())
		grid = append(grid, row)
	}

	var visibleTrees []Tree
	maxScenicScore := 0

	for y := 0; y < len(grid); y++ {
		for x := 0; x < len(grid[y]); x++ {
			tree := Tree{x, y, grid[y][x]}

			north := viewingDistanceFromNorth(grid, tree)
			south := viewingDistanceFromSouth(grid, tree)
			east := viewingDistanceFromEast(grid, tree)
			west := viewingDistanceFromWest(grid, tree)

			scenicScore := north * south * east * west

			fmt.Println(tree.height, "|", north, south, east, west, "|", scenicScore)

			if scenicScore > maxScenicScore {
				maxScenicScore = scenicScore
			}

			if visibleFromNorth(grid, tree) ||
				visibleFromSouth(grid, tree) ||
				visibleFromEast(grid, tree) ||
				visibleFromWest(grid, tree) {
				visibleTrees = append(visibleTrees, tree)
			}
		}
	}

	fmt.Println("Total visible trees: " + strconv.Itoa(len(visibleTrees)))
	fmt.Println("")
	fmt.Print(visibleTrees)

	fmt.Println("")
	fmt.Println("Max scenic score: " + strconv.Itoa(maxScenicScore))
}

func textToSlice(text string) []int {
	var numbers []int

	for _, char := range text {
		number, err := strconv.Atoi(string(char))
		if err != nil {
			log.Fatal(err)
		}
		numbers = append(numbers, number)
	}

	return numbers
}

func visibleFromNorth(grid [][]int, tree Tree) bool {
	for y := tree.y - 1; y >= 0; y-- {
		height := grid[y][tree.x]
		if tree.height <= height {
			return false
		}
	}

	return true
}

func visibleFromSouth(grid [][]int, tree Tree) bool {
	for y := tree.y + 1; y < len(grid); y++ {
		height := grid[y][tree.x]
		if tree.height <= height {
			return false
		}
	}

	return true
}

func visibleFromEast(grid [][]int, tree Tree) bool {
	for x := tree.x + 1; x < len(grid[tree.y]); x++ {
		height := grid[tree.y][x]
		if tree.height <= height {
			return false
		}
	}

	return true
}

func visibleFromWest(grid [][]int, tree Tree) bool {
	for x := tree.x - 1; x >= 0; x-- {
		height := grid[tree.y][x]
		if tree.height <= height {
			return false
		}
	}

	return true
}

func viewingDistanceFromNorth(grid [][]int, tree Tree) int {
	distance := 0

	for y := tree.y - 1; y >= 0; y-- {
		height := grid[y][tree.x]
		distance++
		if tree.height <= height {
			break
		}
	}

	return distance
}

func viewingDistanceFromSouth(grid [][]int, tree Tree) int {
	distance := 0

	for y := tree.y + 1; y < len(grid); y++ {
		height := grid[y][tree.x]
		distance++
		if tree.height <= height {
			break
		}
	}

	return distance
}

func viewingDistanceFromEast(grid [][]int, tree Tree) int {
	distance := 0

	for x := tree.x + 1; x < len(grid[tree.y]); x++ {
		height := grid[tree.y][x]
		distance++
		if tree.height <= height {
			break
		}
	}

	return distance
}

func viewingDistanceFromWest(grid [][]int, tree Tree) int {
	distance := 0

	for x := tree.x - 1; x >= 0; x-- {
		height := grid[tree.y][x]
		distance++
		if tree.height <= height {
			break
		}
	}

	return distance
}
