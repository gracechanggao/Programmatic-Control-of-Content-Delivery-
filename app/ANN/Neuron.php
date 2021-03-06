<?php

/**
 * Artificial Neural Network - Version 2.3
 *
 * For updates and changes visit the project page at http://ann.thwien.de/
 *
 *
 *
 * <b>LICENCE</b>
 *
 * The BSD 2-Clause License
 *
 * http://opensource.org/licenses/bsd-license.php
 *
 * Copyright (c) 2002, Eddy Young
 * Copyright (c) 2007 - 2012, Thomas Wien
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 * 1. Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 *
 * 2. Redistributions in binary form must reproduce the above copyright
 * notice, this list of conditions and the following disclaimer in the
 * documentation and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @author Eddy Young <jeyoung_at_priscimon_dot_com>
 * @author Thomas Wien <info_at_thwien_dot_de>
 * @version ANN Version 1.0 by Eddy Young
 * @version ANN Version 2.3 by Thomas Wien
 * @copyright Copyright (c) 2002 by Eddy Young
 * @copyright Copyright (c) 2007-2012 by Thomas Wien
 * @package ANN
 */

// namespace ANN;
namespace App\ANN;
/**
 * @package ANN
 * @access private
 */

final class Neuron
{
	/**#@+
	 * @ignore
	 */
	 
	use Maths;

	/**
	 * @var array
	 */
	protected $arrInputs = null;

	/**
	 * @var array
	 */
	protected $arrWeights = null;

	/**
	 * @var float
	 */
	protected $floatOutput = null;

	/**
	 * @var float
	 */
	protected $floatDelta = 0;
	
	/**
	 * @var Network
	 */
	
	protected $objNetwork = null;
	protected $floatLearningRate = 0;
	
	/**#@-*/
	
	/**
	 * @param Network $objNetwork
	 * @uses Maths::randomDelta()
	 */
	
	public function __construct(Network $objNetwork)
	{
	  $this->objNetwork = $objNetwork;
	
	  $this->floatDelta = $this->randomDelta();
	  
	  $this->floatLearningRate = $this->objNetwork->floatLearningRate;
	}
	
	/**
	 * @param array &$arrInputs
	 * @uses initializeWeights()
	 */
	
	public function setInputs(&$arrInputs)
	{
		$this->arrInputs = $arrInputs;
	
		$this->arrInputs[] = 1; // bias
		
		if($this->arrWeights === null)
			$this->initializeWeights();
	}
		
	/**
	 * @param float $floatDelta
	 */
	
	public function setDelta($floatDelta)
	{
		$this->floatDelta = $floatDelta;
	}
		
	/**
	 * @return array
	 */
	
	public function getWeights()
	{
		return $this->arrWeights;
	}
	
	/**
	 * @param integer $intKeyNeuron
	 * @return float
	 */
	
	public function getWeight($intKeyNeuron)
	{
		return $this->arrWeights[$intKeyNeuron];
	}
	
	/**
	 * @return float
	 */
	
	public function getOutput()
	{
		return $this->floatOutput;
	}
	
	/**
	 * @return float
	 */
	
	public function getDelta()
	{
		return $this->floatDelta;
	}
	
	/**
	 * @uses Maths::randomWeight()
	 */
	
	protected function initializeWeights()
	{
		foreach($this->arrInputs as $intKey => $floatInput)
			$this->arrWeights[$intKey] = $this->randomWeight();
	}
		
	/**
	 * @uses Maths::sigmoid()
	 */
	
	public function activate()
	{
		$floatSum = 0;
			
		foreach($this->arrInputs as $intKey => $floatInput)
			$floatSum += $floatInput * $this->arrWeights[$intKey];
	
		$this->floatOutput = $this->sigmoid($floatSum);
	}
		
	public function adjustWeights()
	{
		$floatLearningRateDeltaFactor = $this->floatLearningRate * $this->floatDelta;
		    	
		foreach ($this->arrWeights as $intKey => $floatWeight)
			$this->arrWeights[$intKey] += $this->arrInputs[$intKey] * $floatLearningRateDeltaFactor;
	}
}
