//
//  PatrolDataController.m
//  peaceguard
//
//  Created by Lesperance Ashley on 2013-03-10.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import "PatrolDataController.h"

@implementation PatrolDataController

-(void) beginPatrol{
    
    self.currentPatrol = [[Patrol alloc] initWithTime];
    //Connect to the server and get patrolID
}

-(void) endPatrol{
    
    //Connect to the server and send information
}

@end
