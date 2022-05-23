const table = document.getElementById('voorraadList');
/** Sort the table
 * @param column The column to sort. If 0 set to default sorting order instead.
 * @param event The event triggering the action. If given it's used to debounce by setting the css atribute `pointer-events` to `none` for a moment. If a KeyboardEvent it will also ensure the Enter key was the one triggering it.
 * @param defaultSort The column to sort with as default.
 */
function tableSort(column: number, event: MouseEvent|KeyboardEvent|null = null, defaultSort: number = 1): void {
	// Debounce
	if(null != event) {
		if(event instanceof KeyboardEvent && event.key != 'Enter') return;
		(event.target as HTMLTableCellElement).style.pointerEvents = 'none';
	}
	// Prepair variables
	if((!(table instanceof HTMLTableElement)) || table.tHead == null || table.tHead.rows.length < 1) return;
	const colHeaders = (table.tHead.rows[0] as HTMLTableRowElement).children as HTMLCollectionOf<HTMLTableCellElement>;
	var sortedRowHead: number | null = null;
	// Get the rowHead that was already used to sort the table if any.
	for(let index = 1; index < colHeaders.length; index++) {
		const element = colHeaders[index] as HTMLTableCellElement;
		if(element.getAttribute('aria-sort') == null) continue;
		sortedRowHead = index;
		break;
	}
	let action: 0|1|2;
	// Find what action to use. 0 for default, 1 for ascending, 2 for decending.
	if(column == 0) {
		action = 0;
		for(let index = 1; index < colHeaders.length; index++)
			(colHeaders[index] as HTMLTableCellElement).removeAttribute('aria-sort');
		(colHeaders[defaultSort] as HTMLTableCellElement).setAttribute('aria-sort', 'ascending');
		column = defaultSort;
	} else if((column == sortedRowHead) && (colHeaders[column] as HTMLTableCellElement).getAttribute('aria-sort') == 'ascending') {
		action = 2;
		(colHeaders[column] as HTMLTableCellElement).setAttribute('aria-sort', 'descending');
	} else {
		action = 1;
		if(sortedRowHead != null)
			(colHeaders[sortedRowHead] as HTMLTableCellElement).removeAttribute('aria-sort');
		(colHeaders[column] as HTMLTableCellElement).setAttribute('aria-sort', 'ascending');
	}
	const is_num = new RegExp('^[0-9]+$');
	// Sorting the rows in each rowGroup
	var sortingDone: boolean;
	for(let groupIndex = 0; groupIndex < table.tBodies.length; groupIndex++) {
		const group = table.tBodies[groupIndex] as HTMLTableSectionElement;
		sortingDone = true;
		while(sortingDone) {
			sortingDone = false;
			for(let rowIndex = 0; rowIndex < (group.rows.length-1); rowIndex++) {
				const curr_row = (group.rows[rowIndex] as HTMLTableRowElement);
				const next_row = (group.rows[rowIndex+1] as HTMLTableRowElement);
				// Cells with rowspan > 1 are only in the first row so we must get the new columnindex for these.
				const relativeColumn = column - (colHeaders.length - curr_row.cells.length);
				const curr_cell = curr_row.cells[relativeColumn] as HTMLTableCellElement;
				const next_cell = next_row.cells[relativeColumn] as HTMLTableCellElement;
				if(is_num.test(curr_cell.innerText)) {
					if((action != 2 && Number(next_cell.innerText) > Number(curr_cell.innerText)) || (action == 2 && Number(curr_cell.innerText) > Number(next_cell.innerText))) {
						group.insertBefore(next_row, curr_row);
						sortingDone = true;
					}
				} else {
					if((action != 2 && curr_cell.innerText < next_cell.innerText) || (action == 2 && curr_cell.innerText > next_cell.innerText)) {
						group.insertBefore(next_row, curr_row);
						sortingDone = true;
					}
				}
			}
		}
		const firstRow = group.rows[0] as HTMLTableRowElement;
		// Ensure the first row is the one with the elements that span multiple rows
		if(firstRow.cells.length < colHeaders.length) {
			for(let index = 1; index < group.rows.length; index++) {
				const row = group.rows[index] as HTMLTableRowElement;
				if(row.cells.length < colHeaders.length) continue;
				var toInsert = [];
				for(let index = 0; index < row.cells.length; index++) {
					const cell = row.cells[index] as HTMLTableCellElement;
					if(cell.rowSpan == 1) break;
					// Adding them to an array so we can add them back to front.
					toInsert.unshift(cell);
				}
				toInsert.forEach(element => {
					firstRow.insertBefore(element, firstRow.firstChild);
				});
			}
		}
	}
	// Sorting the rowGroups
	sortingDone = true;
	while(sortingDone) {
		sortingDone = false;
		for(let groupIndex = 0; groupIndex < (table.tBodies.length-1); groupIndex++) {
			const curr_group = table.tBodies[groupIndex] as HTMLTableSectionElement;
			const next_group = table.tBodies[groupIndex+1] as HTMLTableSectionElement;
			var curr_order: number | string = 0;
			var next_order: number | string = 0;
			// Whether to use every instance or just the top row for comparing.
			if(((curr_group.rows[0] as HTMLTableRowElement).cells[column] as HTMLTableCellElement).rowSpan < curr_group.rows.length && is_num.test(((curr_group.rows[0] as HTMLTableRowElement).cells[column] as HTMLTableCellElement).innerText)) {
				// Check every row.
				for(let index = 0; index < curr_group.rows.length; index++) {
					const row = curr_group.rows[index] as HTMLTableRowElement;
					// Cells with rowspan > 1 are only in the first row so we must get the new columnindex for these.
					const relativeColumn = column - (colHeaders.length - row.cells.length);
					curr_order += Number((row.cells[relativeColumn] as HTMLTableCellElement).innerText);
				}
				for(let index = 0; index < next_group.rows.length; index++) {
					const row = next_group.rows[index] as HTMLTableRowElement;
					// Cells with rowspan > 1 are only in the first row so we must get the new columnindex for these.
					const relativeColumn = column - (colHeaders.length - row.cells.length);
					next_order += Number((row.cells[relativeColumn] as HTMLTableCellElement).innerText);
				}
			} else {
				curr_order = ((curr_group.rows[0] as HTMLTableRowElement).cells[column] as HTMLTableCellElement).innerText;
				next_order = ((next_group.rows[0] as HTMLTableRowElement).cells[column] as HTMLTableCellElement).innerText;
			}
			if((action != 2 && next_order > curr_order) || (action == 2 && curr_order > next_order)) {
				table.insertBefore(next_group, curr_group);
				sortingDone = true;
			}
		}
	}
	// Reënabling the sort action after an aditional delay.
	if(null != event) setTimeout(() => (event.target as HTMLTableCellElement).style.pointerEvents = '', 950);
}
/**Extracts the results from the form and triggers `tableFilter()`*/
function handleFilter(event: MouseEvent): void {
	const form = ((event.target as HTMLButtonElement|HTMLInputElement).form as HTMLFormElement);
	form.style.pointerEvents = 'none';
	const formData = new FormData(form);
	var query = null;
	var size = null;
	if((event.target as HTMLButtonElement|HTMLInputElement).type != 'reset') {
		for(var pair of formData.entries()) {
			switch(pair[0]) {
				case 'search':
					query = pair[1].toString();
					if(query == '') query = null;
					break;
				case 'maat':
					size = pair[1].toString();
					if(size == '') size = null;
					break;
			}
		}
	}
	tableFilter(query, size);
	setTimeout(() => form.style.pointerEvents = '', 950);
}
function tableFilter(searchQuery: null|string|RegExp = null, size: null|string = null, alt_search: boolean = false): void {
	if(!(table instanceof HTMLTableElement)) return;
	let alt_search_q: string[]|undefined;
	if(typeof searchQuery == 'string') {
		if(alt_search) alt_search_q = searchQuery.split(' ');
		searchQuery = new RegExp(searchQuery, 'i');
	}
	// Prevent sorting size if there is only one size.
	(((table.tHead as HTMLTableSectionElement).rows[0] as HTMLTableRowElement).cells[2] as HTMLTableCellElement).style.pointerEvents = (size == null)? '':'none';
	// Add `data-filtered` class if there is only one size.
	if(size == null) table.classList.remove('data-filtered'); else table.classList.add('data-filtered');
	for(let groupIndex = 0; groupIndex < table.tBodies.length; groupIndex++) {
		const group = table.tBodies[groupIndex] as HTMLTableSectionElement;
		if(searchQuery != null) {
			if(undefined != alt_search_q) {
				var alt_search_v = ((group.rows[0] as HTMLTableRowElement).cells[1] as HTMLTableCellElement).innerText.split(' ');
				alt_search_v.forEach((element, index) => alt_search_v[index] = element.toLowerCase());
				if(!alt_search_q.every(value => alt_search_v.indexOf(value.toLowerCase()) != -1)) {
					group.style.display = 'none';
					continue;
				}
			} else if(((group.rows[0] as HTMLTableRowElement).cells[1] as HTMLTableCellElement).innerText.match(searchQuery) == null) {
				group.style.display = 'none';
				continue;
			}
		}
		group.style.display = '';
		for(let rowIndex = 0; rowIndex < group.rows.length; rowIndex++) {
			const row = (group.rows[rowIndex] as HTMLTableRowElement);
			const value = (row.cells[(rowIndex == 0)? 2:0] as HTMLTableCellElement).innerText;
			let result: boolean;
			switch(size) {
				case 'XS':
					result = (value == 'XS' || value == '116')? true:false;
					break;
				case 'S':
					result = (value == 'S' || value == '128')? true:false;
					break;
				case 'M':
					result = (value == 'M' || value == '140')? true:false;
					break;
				case 'L':
					result = (value == 'L' || value == '152')? true:false;
					break;
				case 'XL':
					result = (value == 'XL' || value == '164')? true:false;
					break;
				case 'XXL':
					result = (value == 'XXL')? true:false;
					break;
				default:
					result = true;
					break;
			}
			row.style.display = (result)? '':'none';
			if(size == 'any' || size == null) {
				if((((table.tHead as HTMLTableSectionElement).rows[0] as HTMLTableRowElement).children[2] as HTMLTableCellElement).getAttribute('aria-sort') == null)
					tableSort(2);
			} else if(result && rowIndex != 0) {
				group.insertBefore(row, group.rows[0] as HTMLTableRowElement);
				(((table.tHead as HTMLTableSectionElement).rows[0] as HTMLTableRowElement).children[2] as HTMLTableCellElement).removeAttribute('aria-sort');
			}
		}
		// Ensure the first row is the one with more than 4 elements.
		if((group.rows[0] as HTMLTableRowElement).cells.length < 5) {
			for(let index = 1; index < group.rows.length; index++) {
				const row = group.rows[index] as HTMLTableRowElement;
				if(row.cells.length < 5) continue;
				const firstRow = group.rows[0] as HTMLTableRowElement;
				const image = row.cells[0] as HTMLTableCellElement;
				const title = row.cells[1] as HTMLTableCellElement;
				firstRow.insertBefore(title, firstRow.firstChild);
				firstRow.insertBefore(image, title);
			}
		}
	}
	// I don't know why this happens but _only_ the first row doesn't reset properly.
	if(size == 'any' || size == null) (table.rows[1] as HTMLTableRowElement).style.display = '';
}
/**
 * Merges cells in the same column that have the same content by modifying rowSpan of the top one and hiding the bottom one.
 * @param table The table or table section you want to check for duplicates.
 * @param columns Either the columnindex you want to modify, an array of columnindexes to modify or -1 for all columns.
 * @throws RangeError On providing columns with an array containing a negative value.
 * @deprecated
 */
function checkCells(table: HTMLTableElement|HTMLTableSectionElement, columns: number[]|number = -1, start: number = 0): void {
	// if(!(table instanceof HTMLTableElement || table instanceof HTMLTableSectionElement)) return;
	if(typeof columns == 'number') {
		if(columns >= 0)
			columns = [columns];
		else
			columns = [...Array(table.rows.length).keys()];
	} else {
		if(columns.length == 0) return;
		if(Math.min(...columns) < 0)
			throw new RangeError('Provided invalid number[] in parameter columns: Array may not contain negative values.');
	}
	const last_columns: HTMLTableCellElement[] = [];
	for (let index = start; index < table.rows.length; index++) {
		const element = table.rows[index] as HTMLTableRowElement;
		if(element.cells.length < Math.max(...columns)) continue;
		for (const value of columns) {
			if(index != start && (last_columns[value] as HTMLTableCellElement).innerHTML == (element.cells[value] as HTMLTableCellElement).innerHTML) {
				(last_columns[value] as HTMLTableCellElement).rowSpan += 1;
				(element.cells[value] as HTMLTableCellElement).style.display = 'none';
			} else
				last_columns[value] = (element.cells[value] as HTMLTableCellElement);
		}
	}
}//*/
/**
 * Merges cells in the same column that have the same content by modifying rowSpan of the top one and hiding the bottom one.
 * Cannot deal with tables that already have cells spanning multiple rows.
 * @param table The table or table section you want to check for duplicates.
 * @param columns Either the columnindex you want to check, an array of columnindexes to check or -1 to check all columns for merge possibilities.
 * @param groupOn If not negative; try and put merged rows, based on the rowindex provided, into their own div.
 * @throws RangeError On providing columns with an array containing a negative value.
 * @throws EvalError When the function finds a cell that already spans multiple rows.
 */
function mergeRows(table: HTMLTableElement, columns: number[]|number = -1, groupOn: number = -1): void {
	// Convert number into number[].
	if(typeof columns == 'number')
		columns = (columns >= 0)? [columns] : columns = [...Array(table.rows.length).keys()];
	else { // Check format
		if(columns.length == 0) return;
		if(Math.min(...columns) < 0)
			throw new RangeError('Provided invalid number[] in parameter columns: Array may not contain negative values.');
	}
	/**Holds table data that will eventually replace the existing tablecontent.*/
	const newTable = document.createElement('table');
	// Just copy tHead as we don't test it.
	newTable.tHead = table.tHead;
	/**Holds the rows from table.tBodies so we can iterate over them.*/
	const rows: HTMLTableRowElement[] = [];
	/**Array containing `[startindex, endindex]` for each tBody that is to be created.*/
	const groups: number[][] = [];
	/**Start index for the next group.*/
	var start_num: number = 0;
	// Convert the tBodies into HTMLTableRowElement[]
	for (let index = 0; index < table.tBodies.length; index++) {
		const row_coll = (table.tBodies[index] as HTMLTableSectionElement).rows;
		for (let index = 0; index < row_coll.length; index++)
			rows.push(row_coll[index] as HTMLTableRowElement);
	}
	// If there aren't any rows we don't have to do anything.
	if(rows[0] == undefined) return;
	// We can't compare with previous if there is no previous. So we skip proccessing row 0 and directly put it into last_columns.
	const last_columns: (HTMLTableCellElement|undefined)[] = Array.from(rows[0].cells);
	for (let rowIndex = 1; rowIndex < rows.length; rowIndex++) {
		const curr_columns = (rows[rowIndex] as HTMLTableRowElement).cells;
		const to_remove: HTMLTableCellElement[] = [];
		// Only check the indexes we are told to check.
		for (const colIndex of columns) {
			const curr_cell = curr_columns[colIndex];
			const last_cell = last_columns[colIndex];
			if(curr_cell !== undefined && curr_cell.rowSpan != 1) throw EvalError('Cell already spanning multiple rows.');
			// If they both exist and contents are the same.
			if(curr_cell !== undefined && last_cell !== undefined && last_cell.innerHTML === curr_cell.innerHTML) {
				last_cell.rowSpan += 1;
				to_remove.push(curr_cell);
			} else {
				if(colIndex == groupOn) {
					groups.push([start_num, rowIndex - 1]);
					start_num = rowIndex;
				}
				last_columns[colIndex] = curr_cell;
			}
		}
		to_remove.forEach(element => element.remove());
	}
	// Also push the last row/set of rows.
	groups.push([start_num, rows.length - 1]);
	groups.forEach(value => {
		const tbody = document.createElement('tbody');
		for (let index = (value[0] as number); index <= (value[1] as number); index++) {
			const row = rows[index] as HTMLTableRowElement;
			tbody.appendChild(row);
		}
		newTable.appendChild(tbody);
	});
	newTable.tFoot = table.tFoot;
	// `table.replaceChildren(...newTable.childNodes)` Seems faster than `table.innerHTML = newTable.innerHTML;` by 0 to 9 ms
	table.replaceChildren(...newTable.childNodes);
	newTable.remove();
}
(table instanceof HTMLTableElement)? mergeRows(table, [0, 1], 1) : console.warn('Table not found.');